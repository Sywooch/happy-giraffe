<?php

/**
 * This is the model class for table "comment".
 *
 * The followings are the available columns in table 'comment':
 * @property string $id
 * @property string $text
 * @property string $created
 * @property string $author_id
 * @property string $entity
 * @property string $entity_id
 * @property string $response_id
 * @property string $quote_id
 * @property string $quote_text
 * @property string $position
 * @property string $removed
 *
 * The followings are the available model relations:
 * @property User author
 * @property Comment $response
 * @property Comment $quote
 * @property AttachPhoto[] $photoAttaches
 * @property AttachPhoto $photoAttach
 */
class Comment extends HActiveRecord
{
    public $selectable_quote = false;
    const CONTENT_TYPE_DEFAULT = 1;
    const CONTENT_TYPE_PHOTO = 2;
    const CONTENT_TYPE_ONLY_TEXT = 3;

    public $count;

    /**
     * Returns the static model of the specified AR class.
     * @return Comment the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'comments';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('author_id, entity, entity_id', 'required'),
            array('text', 'required', 'on' => 'default'),
            array('author_id, entity_id, response_id, quote_id', 'length', 'max' => 11),
            array('entity', 'length', 'max' => 255),
            array('text, position, quote_text, selectable_quote', 'safe'),
            array('removed', 'boolean'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, text, created, author_id, entity, entity_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'author' => array(self::BELONGS_TO, 'User', 'author_id'),
            'response' => array(self::BELONGS_TO, 'Comment', 'response_id'),
            'quote' => array(self::BELONGS_TO, 'Comment', 'quote_id'),
            'remove' => array(self::HAS_ONE, 'Removed', 'entity_id', 'condition' => '`remove`.`entity` = :entity', 'params' => array(':entity' => get_class($this))),

            'photoAttaches' => array(self::HAS_MANY, 'AttachPhoto', 'entity_id', 'condition' => 'entity = :entity', 'params' => array(':entity' => get_class($this))),
            //'photoAttaches' => array(self::HAS_MANY, 'AttachPhoto', 'entity_id', 'condition' => '`photoAttaches`.`entity` = :entity', 'params' => array(':entity' => get_class($this))),
            'photoAttach' => array(self::HAS_ONE, 'AttachPhoto', 'entity_id', 'condition' => 'entity = :entity', 'params' => array(':entity' => get_class($this))),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'text' => 'Text',
            'created' => 'Created',
            'author_id' => 'Author',
            'entity' => 'Entity',
            'entity_id' => 'Entity PK',
            'response_id' => 'Response id',
            'quote_id' => 'Quote id',
            'quote_text' => 'Quote text',
            'position' => 'Позиция',
            'removed' => 'Удален',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('author_id', $this->author_id, true);
        $criteria->compare('entity', $this->entity, true);
        $criteria->compare('entity_id', $this->entity_id, true);
        $criteria->compare('response_id', $this->response_id, true);
        $criteria->compare('quote_id', $this->quote_id, true);
        $criteria->compare('removed', $this->removed, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
            ),
            'purified' => array(
                'class' => 'site.common.behaviors.PurifiedBehavior',
                'attributes' => array('text', 'preview'),
                'options' => array(
                    'AutoFormat.Linkify' => true,
                ),
            ),
            'externalImages' => array(
                'class' => 'site.common.behaviors.ExternalImagesBehavior',
                'attributes' => array('text'),
            ),
            'duplicate' => array(
                'class' => 'site.common.behaviors.DuplicateBehavior',
                'attribute' => 'text',
                'error_text' => 'Вы только что создали рецепт с таким названием'
            )
        );
    }

    public function defaultScope()
    {
        $alias = $this->getTableAlias(false, false);
        return array(
            'condition' => ($alias) ? $alias . '.removed = 0' : 'removed = 0',
        );
    }

    public function get($entity, $entity_id, $pageSize = 25)
    {
        return new CActiveDataProvider('Comment', array(
            'criteria' => array(
                'condition' => 't.entity=:entity AND t.entity_id=:entity_id',
                'params' => array(':entity' => $entity, ':entity_id' => $entity_id),
                'with' => array(
                    'author' => array(
                        'select' => 'id, gender, first_name, last_name, online, avatar_id, deleted',
                        'with' => 'avatar',
                    )
                ),
                'order' => 't.created ASC',
            ),
            'pagination' => array(
                'pageSize' => $pageSize,
            ),
        ));
    }

    public function afterSave()
    {
        if (get_class(Yii::app()) == 'CConsoleApplication')
            return;

        if ($this->isNewRecord) {
            if (in_array($this->entity, array('CommunityContent', 'BlogContent'))) {
                $relatedModel = $this->getRelatedModel();
                $relatedModel->last_updated = new CDbExpression('NOW()');
                $relatedModel->update(array('last_updated'));
                $relatedModel->sendEvent();

                //пересчитываем рейтинг только если кол-во комментариев кратно 5-ти
                $commentsCount = Yii::app()->db->createCommand()
                    ->select('count(*)')
                    ->from('comments')
                    ->where('entity=:entity AND entity_id=:entity_id AND removed = 0',
                        array(':entity' => $this->entity, ':entity_id' => $this->entity_id))
                    ->queryScalar();
                if ($commentsCount % 5 == 0)
                    PostRating::getInstance()->reCalc($relatedModel);
            }

            Yii::import('site.frontend.modules.routes.models.*');
            NotificationCreate::commentCreated($this);
            Scoring::commentCreated($this);

            FriendEventManager::add(FriendEvent::TYPE_COMMENT_ADDED, array('model' => $this, 'relatedModel' => $this->relatedModel));

            //send signals to commentator panel
            if (Yii::app()->user->checkAccess('commentator_panel')) {
                Yii::import('site.frontend.modules.signal.components.*');
                Yii::import('site.frontend.modules.signal.models.*');
                Yii::import('site.frontend.modules.signal.helpers.*');
                Yii::import('site.frontend.modules.cook.models.*');
                Yii::import('site.frontend.modules.cook.components.*');
                Yii::import('site.seo.modules.commentators.models.*');
                Yii::import('site.seo.models.*');

                if (Str::htmlTextLength($this->text) >= CommentatorHelper::COMMENT_LIMIT)
                    CommentatorWork::getCurrentUser()->checkComment($this);
            }
        }
        parent::afterSave();
    }

    public function beforeSave()
    {
        /* Вырезка цитаты */
        $find = '/<div class="quote">(.*)<\/div>/ims';
        preg_match($find, $this->text, $matches);
        if (isset($this->quote_id)) {
            if (count($matches) > 0) {
                $this->text = preg_replace($find, '', $this->text);
                if ($this->selectable_quote == 1) {
                    $this->quote_text = $matches[1];
                }
            } else {
                $this->quote_text = '';
                $this->quote_id = null;
            }
        }

        if (isset($this->response_id) && $this->response_id == '')
            $this->response_id = null;


        if ($this->isNewRecord) {
            $criteria = new CDbCriteria(array(
                'select' => 'position',
                'order' => 'created DESC',
                'limit' => 1,
                'condition' => 'entity = :entity and entity_id = :entity_id',
                'params' => array(':entity' => $this->entity, ':entity_id' => $this->entity_id)
            ));
            $model = $this->find($criteria);
            if (!$model)
                $position = 1;
            else
                $position = $model->position + 1;
            $this->position = $position;
        }
        return parent::beforeSave();
    }

    public function beforeDelete()
    {
        Comment::model()->updateByPk($this->id, array('removed' => 1));
        NotificationDelete::commentDeleted($this);
        Scoring::commentRemoved($this);


        return false;
    }

    public function afterDelete()
    {
        $this->renewPosition();
        parent::afterDelete();
    }

    public static function getUserAvarageCommentsCount($user)
    {
        $comments_count = Comment::model()->count('author_id=' . $user->id);
        if ($comments_count == 0)
            return 0;
        $days = ceil(strtotime(date("Y-m-d H:i:s")) - strtotime($user->register_date) / 86400);
        if ($days == 0)
            $days = 1;

        return round($comments_count / $days);
    }


    /**
     * Пересчитывает позиции группы коментариев внутри сущности
     */
    public function renewPosition()
    {
        $criteria = new CDbCriteria(array(
            'select' => '*',
            'order' => 'created ASC',
            'condition' => 'entity = :entity and entity_id = :entity_id',
            'params' => array(':entity' => $this->entity, ':entity_id' => $this->entity_id)
        ));
        $index = 0;
        $comments = Comment::model()->findAll($criteria);
        foreach ($comments as $model) {
            $index++;
            $model->position = $index;
            $model->save();
        }
    }

    /**
     * @static
     * Пересчитывает позиции ВСЕХ комментариев
     */
    public static function updateComments()
    {
        $criteria = new CDbCriteria;
        $criteria->group = 'entity, entity_id';
        $criteria->select = '*';
        $comments = Comment::model()->findAll($criteria);
        foreach ($comments as $c) {
            $cr = new CDbCriteria;
            $cr->condition = 'entity = :entity and entity_id = :entity_id';
            $cr->params = array(':entity' => $c->entity, ':entity_id' => $c->entity_id);
            $cr->order = 'created ASC';
            $comment = Comment::model()->findAll($cr);
            $index = 0;
            foreach ($comment as $km) {
                $index++;
                $km->position = $index;
                $km->save(false);
            }
        }
    }

    public function getUrl($absolute = false)
    {
        if (!in_array($this->entity, array('CommunityContent', 'BlogContent', 'CookRecipe', 'User',
            'AlbumPhoto', 'Route', 'Service'))
        )
            return false;

        $entity = CActiveRecord::model($this->entity)->findByPk($this->entity_id);
        if ($entity === null)
            return '';
        if ($this->entity == 'Service') {
            $url = $entity->getUrl();
            $page = $this->calcPageNumber();
            if ($page > 1)
                $url .= '?Comment_page=' . $page;
            return $url . '#comment_' . $this->id;
        }

        list($route, $params) = $entity->urlParams;
        $params['#'] = 'comment_' . $this->id;

        //add page param
        $page = $this->calcPageNumber();
        if ($page > 1)
            $params['Comment_page'] = $page;

        $method = $absolute ? 'createAbsoluteUrl' : 'createUrl';
        return Yii::app()->$method($route, $params);
    }

    public function calcPageNumber()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'id < :id';
        $criteria->params = array(':id' => $this->id);
        $criteria->compare('entity', $this->entity);
        $criteria->compare('entity_id', $this->entity_id);

        $count = Comment::model()->count($criteria) + 1;

        return ceil($count / 25);
    }

    public function getLink($absolute = false)
    {
        if (!in_array($this->entity, array('CommunityContent', 'BlogContent', 'CookRecipe', 'User', 'AlbumPhoto')))
            return false;

        $entity = CActiveRecord::model($this->entity)->findByPk($this->entity_id);
        list($route, $params) = $entity->urlParams;
        $params['#'] = 'comment_' . $this->id;

        $method = $absolute ? 'createAbsoluteUrl' : 'createUrl';
        return CHtml::link($entity->title . ' #' . $this->id, Yii::app()->$method($route, $params), array('target' => '_blank'));
    }

    public function isEntityAuthor($user_id)
    {
        $class = $this->entity;
        $pk = $this->entity_id;
        $model = $class::model()->cache(1)->findByPk($pk);
        if ($model !== null) {
            if (isset($model->author_id) && $model->author_id == $user_id)
                return true;
            if ($this->entity == 'User' && $model->id == $user_id)
                return true;
        }
        return false;
    }

    public function getContentType()
    {
        if ($this->entity == 'User')
            return self::CONTENT_TYPE_ONLY_TEXT;
        elseif (empty($this->photoAttaches))
            return self::CONTENT_TYPE_DEFAULT; else
            return self::CONTENT_TYPE_PHOTO;
    }

    public function getRemoveDescription()
    {
        switch ($this->remove->type) {
            case 0 :
                $text = 'Комментарий удален автором.';
                break;
            case 5 :
                $text = 'Комментарий удален владельцем страницы.';
                break;
            case 4 :
                $text = 'Комментарий удален модератором.';
                break;
            default:
                $text = 'Комментарий удален. Причина: ' . Removed::$types[$this->remove->type];
                break;
        }
        return $text;
    }

    public function getGroupRemoveDescription($comments, $first, $last)
    {
        $byAuthor = false;
        $byOwner = false;
        $byModer = false;
        $reasons = array();
        foreach ($comments as $c) {
            switch ($c->remove->type) {
                case 0:
                    $byAuthor = true;
                    break;
                case 5:
                    $byOwner = true;
                    break;
                default:
                    $byModer = true;
                    if ($c->remove->type == 4) {
                        $reasons[] = $c->remove->text;
                    } else {
                        $reasons[] = Removed::$types[$c->remove->type];
                    }
            }
        }

        $words = array();
        if ($byAuthor)
            $words[] = 'автором';

        if ($byOwner)
            $words[] = 'владельцем страницы';

        if ($byModer) {
            foreach ($reasons as $k => $r)
                $reasons[$k] = '"' . $r . '"';
            $words[] = 'модератором по ' . ((count($reasons) > 1) ? 'причинам' : 'причине') . ' ' . HDate::enumeration($reasons);
        }

        return ((count($comments) > 1) ? 'Комментарии с ' . $first . ' по ' . $last . ' были удалены' : 'Комментарий был удалён') . ' ' . HDate::enumeration($words);
    }

    public function isTextComment()
    {
        return empty($this->photoAttaches);
    }

    /**
     * Первый коммент от веселого жирафа
     * @param $user_id
     */
    public function addGiraffeFirstComment($user_id)
    {
        //коммент от веселого жирафа
        $comment = new Comment('giraffe');
        $comment->author_id = User::HAPPY_GIRAFFE;
        $comment->entity = 'User';
        $comment->entity_id = $user_id;
        $comment->save();

        $attach = new AttachPhoto;
        $attach->entity = 'Comment';
        $attach->entity_id = $comment->id;
        $attach->photo_id = 35000;
        $attach->save();
    }

    public static function getNewCommentsCount($entity, $entity_id, $last_comment_id)
    {
        return Yii::app()->db->createCommand()
            ->select('count(*)')
            ->from('comments')
            ->where('entity=:entity AND entity_id=:entity_id AND id > :last_comment_id AND removed=0', array(
                ':entity' => $entity,
                ':entity_id' => $entity_id,
                ':last_comment_id' => $last_comment_id
            ))
            ->queryScalar();
    }

    public static function getNewCommentIds($entity, $entity_id, $last_comment_id)
    {
        return Yii::app()->db->createCommand()
            ->select('id')
            ->from('comments')
            ->where('entity=:entity AND entity_id=:entity_id AND id > :last_comment_id AND removed=0', array(
                ':entity' => $entity,
                ':entity_id' => $entity_id,
                ':last_comment_id' => $last_comment_id
            ))
            ->queryColumn();
    }

    public function getPowerTipTitle()
    {
        $entity = CActiveRecord::model($this->entity)->findByPk($this->entity_id);
        if (method_exists($entity, 'getPowerTipTitle'))
            return $entity->getPowerTipTitle(true);
        else
            return '';
    }

    public function restore(){
        Comment::model()->updateByPk($this->id, array('removed' => 0));
        Removed::model()->restoreByEntity($this);
    }

    /**
     * @param Comment[] $comments
     * @return array
     */
    public static function getViewData($comments)
    {
        $data = array();
        foreach ($comments as $comment)
            $data[] = self::getOneCommentViewData($comment);

        return $data;
    }

    /**
     * @param Comment $comment
     * @return array
     */
    public static function getOneCommentViewData($comment)
    {
        return array(
                'id' => (int)$comment->id,
                'html' => $comment->purified->text,
                'created' => Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $comment->created),
                'author' => array(
                    'id' => (int)$comment->author->id,
                    'firstName' => $comment->author->first_name,
                    'lastName' => $comment->author->last_name,
                    'gender' => $comment->author->gender,
                    'avatar' => $comment->author->getAva('small'),
                    'online' => (bool)$comment->author->online,
                    'url' => $comment->author->getUrl(),
                ),
                'likesCount' => HGLike::model()->countByEntity($comment),
                'userLikes' => HGLike::model()->hasLike($comment, Yii::app()->user->id),
                'canRemove' => (Yii::app()->user->model->checkAuthItem('removeComment') || Yii::app()->user->id == $comment->author_id || $comment->isEntityAuthor(Yii::app()->user->id)),
                'canEdit' => (Yii::app()->user->model->checkAuthItem('editComment') || Yii::app()->user->id == $comment->author_id),
            );
    }
}