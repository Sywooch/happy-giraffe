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
 * @property string $root_id
 * @property string $removed
 * @property CommunityContent $commentEntity Комментируемая сущность
 *
 * The followings are the available model relations:
 * @property User author
 * @property Comment $response
 */
class Comment extends HActiveRecord
{

    /**
     * Комментируемая сущность
     * @var CActiveRecord 
     */
    protected $_entity = null;

    /**
     * Массив фото, содержащихся в тексте, заполняется поведением ProcessingImagesBehavior
     * @var array
     */
    public $processed_photos = array();

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
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
            array('text', 'CommentRequiredValidator', 'on' => 'default'),
            array('text', 'safe'),
            array('author_id, entity_id, response_id', 'numerical', 'allowEmpty' => true, 'integerOnly' => true),
            array('entity', 'length', 'max' => 255),
            array('removed', 'boolean'),
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
            'removed' => 'Удален',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function behaviors()
    {
        return array(
            'ContentBehavior' => array(
                'class' => 'site\frontend\modules\notifications\behaviors\ContentBehavior',
            ),
            'notificationBehavior' => array(
                'class' => 'site\frontend\modules\notifications\behaviors\CommentBehavior',
            ),
            'CTimestampBehavior' => array(
                'class' => 'site.common.behaviors.HTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
            ),
            'purified' => array(
                'class' => 'site.common.behaviors.PurifiedBehavior',
                'attributes' => array('text'),
                'options' => array(
                    'AutoFormat.Linkify' => true,
                ),
            ),
            'processingImages' => array(
                'class' => 'site.common.behaviors.ProcessingImagesBehavior',
                'attributes' => array('text'),
            ),
            'duplicate' => array(
                'class' => 'site.common.behaviors.DuplicateBehavior',
                'attribute' => 'text',
                'error_text' => 'Вы только что создали комментарий с таким названием'
            ),
            'forEdit' => array(
                'class' => 'site.common.behaviors.PrepareForEdit',
                'attributes' => array('text'),
            ),
            'antispam' => array(
                'class' => 'site.frontend.modules.antispam.behaviors.AntispamBehavior',
                'interval' => 1.5 * 60,
                'maxCount' => 4,
            ),
            'softDelete' => array(
                'class' => 'site.common.behaviors.SoftDeleteBehavior',
            ),
        );
    }

    public function get($entity, $entity_id, $pageSize = 25)
    {
        throw new Exception('deprecated');
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

        if ($this->isNewRecord)
        {
            if (in_array($this->entity, array('CommunityContent', 'BlogContent', 'AlbumPhoto')))
            {
                PostRating::reCalcFromComments($this);
            }

            Yii::import('site.frontend.modules.routes.models.*');
            Scoring::commentCreated($this);

            //send signals to commentator panel
            if (Yii::app()->user->checkAccess('commentator_panel'))
            {
                Yii::import('site.frontend.modules.signal.components.*');
                Yii::import('site.frontend.modules.signal.models.*');
                Yii::import('site.frontend.modules.signal.helpers.*');
                Yii::import('site.frontend.modules.cook.models.*');
                Yii::import('site.frontend.modules.cook.components.*');
                Yii::import('site.seo.modules.commentators.models.*');
                Yii::import('site.seo.models.*');

                if (CommentatorHelper::getStringLength($this->text) >= CommentatorHelper::COMMENT_LIMIT)
                    CommentatorWork::getCurrentUser()->checkComment($this);
            }
        }
        parent::afterSave();
    }
    
    public function insert($attributes = null)
    {
        $result = parent::insert($attributes);
        // обновим root_id
        $this->root_id = is_null($this->response_id) ? $this->id : $this->response->root_id;
        // сделаем это быстро
        $this->updateByPk($this->id, array('root_id' => $this->root_id));
        
        return $result;
    }

    public function beforeSave()
    {
        if (empty($this->response_id))
            $this->response_id = null;

        return parent::beforeSave();
    }

    public function beforeDelete()
    {
        Comment::model()->updateByPk($this->id, array('removed' => 1));

        /** @todo Переписать через save */
        $this->removed = 1;
        $notification = $this->asa('notificationBehavior');
        if ($notification)
            $notification->afterSave(new CEvent($this));

        Scoring::commentRemoved($this);

        return false;
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

    public function getUrl($absolute = false)
    {
        if (!in_array($this->entity, array('CommunityContent', 'BlogContent', 'CookRecipe', 'User',
                'AlbumPhoto', 'Route', 'Service'))
        )
            return false;

        $entity = CActiveRecord::model($this->entity)->findByPk($this->entity_id);
        if ($entity === null)
            return '';
        if ($this->entity == 'Service')
        {
            $url = $entity->getUrl();
//            $page = $this->calcPageNumber();
//            if ($page > 1)
//                $url .= '?Comment_page=' . $page;
            return $url . '#comment_' . $this->id;
        }

        list($route, $params) = $entity->urlParams;
        $params['#'] = 'comment_' . $this->id;

        //add page param
//        $page = $this->calcPageNumber();
//        if ($page > 1)
//            $params['Comment_page'] = $page;

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
        if ($model !== null)
        {
            if (isset($model->author_id) && $model->author_id == $user_id)
                return true;
            if ($this->entity == 'User' && $model->id == $user_id)
                return true;
        }
        return false;
    }

    public function getRemoveDescription()
    {
        return 'Комментарий удалён';
        throw new Exception('deprecated');
/*
        if (!$this->remove && $this->removed)
            return 'Комментарий удален';
        if (!$this->remove && !$this->removed)
            return null;
        switch ($this->remove->type)
        {
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
        return $text;*/
    }

    public function getGroupRemoveDescription($comments, $first, $last)
    {
        throw new Exception('deprecated');
/*        $byAuthor = false;
        $byOwner = false;
        $byModer = false;
        $reasons = array();
        foreach ($comments as $c)
        {
            switch ($c->remove->type)
            {
                case 0:
                    $byAuthor = true;
                    break;
                case 5:
                    $byOwner = true;
                    break;
                default:
                    $byModer = true;
                    if ($c->remove->type == 4)
                    {
                        $reasons[] = $c->remove->text;
                    }
                    else
                    {
                        $reasons[] = Removed::$types[$c->remove->type];
                    }
            }
        }

        $words = array();
        if ($byAuthor)
            $words[] = 'автором';

        if ($byOwner)
            $words[] = 'владельцем страницы';

        if ($byModer)
        {
            foreach ($reasons as $k => $r)
                $reasons[$k] = '"' . $r . '"';
            $words[] = 'модератором по ' . ((count($reasons) > 1) ? 'причинам' : 'причине') . ' ' . HDate::enumeration($reasons);
        }

        return ((count($comments) > 1) ? 'Комментарии с ' . $first . ' по ' . $last . ' были удалены' : 'Комментарий был удалён') . ' ' . HDate::enumeration($words);*/
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
        $entity = $this->getCommentEntity();
        if (method_exists($entity, 'getPowerTipTitle'))
            return $entity->getPowerTipTitle(true);
        else
            return '';
    }

    /**
     * @param Comment[] $comments
     * @param bool $album_comments Комментарии к альбому?
     * @return array
     */
    public static function getViewData($comments, $album_comments = false)
    {
        $data = array();
        foreach ($comments as $comment)
            $data[] = self::getOneCommentViewData($comment, $album_comments);

        return $data;
    }

    /**
     * @return CommunityContent
     */
    public function getCommentEntity()
    {
        if (is_null($this->_entity))
            $this->_entity = CActiveRecord::model($this->entity)->findByPk($this->entity_id);

        return $this->_entity;
    }

    /**
     * @param Comment $comment
     * @param bool $album_comments Комментарии к альбому?
     * @return array
     */
    public static function getOneCommentViewData($comment, $album_comments)
    {
        $comment->forEdit->text;
        $data = array(
            'id' => (int) $comment->id,
            'html' => $comment->purified->text,
            'editHtml' => $comment->forEdit->text,
            'created' => strtotime($comment->created),
            'author' => array(
                'id' => (int) $comment->author->id,
                'firstName' => $comment->author->first_name,
                'lastName' => $comment->author->last_name,
                'gender' => $comment->author->gender,
                'avatar' => $comment->author->getAvatarUrl(40),
                'online' => (bool) $comment->author->online,
                'url' => $comment->author->getUrl(),
                'deleted' => $comment->author->deleted,
            ),
            'likesCount' => HGLike::model()->countByEntity($comment),
            'userLikes' => HGLike::model()->hasLike($comment, Yii::app()->user->id),
            'canRemove' => (!Yii::app()->user->isGuest && Yii::app()->user->group != UserGroup::USER && Yii::app()->user->model->checkAuthItem('removeComment') || (Yii::app()->user->id == $comment->author_id && Yii::app()->user->id != 167771) || $comment->isEntityAuthor(Yii::app()->user->id)),
            'canEdit' => (!Yii::app()->user->isGuest && Yii::app()->user->group != UserGroup::USER && Yii::app()->user->model->checkAuthItem('editComment') || (Yii::app()->user->id == $comment->author_id && Yii::app()->user->id != 167771)),
            'photoUrl' => ($album_comments && $comment->entity == 'AlbumPhoto') ? $comment->getCommentEntity()->getPreviewUrl(170, 110, false, true) : false,
            'photoId' => ($album_comments && $comment->entity == 'AlbumPhoto') ? $comment->getCommentEntity()->id : false,
            'specialistLabel' => ($comment->entity == 'CommunityContent' && $comment->getCommentEntity()->type_id == CommunityContentType::TYPE_QUESTION && ($specialist = $comment->author->getSpecialist($comment->getCommentEntity()->rubric->community_id)) !== null) ? mb_strtolower($specialist->title, 'UTF-8') : null,
        );
        return $data;
    }
    
    /* scopes */

    public function defaultScope()
    {
        $alias = $this->getTableAlias(false, false);
        return array(
            'condition' => ($alias) ? $alias . '.removed = 0' : 'removed = 0',
        );
    }

    public function scopes()
    {
        return array( 
            'specialSort' => array(
                'order' => $this->tableAlias . '.`root_id` DESC, IF(' . $this->tableAlias . '.`root_id` IS NULL, 0, ' . $this->tableAlias . '.`created`) ASC'
            ),
        );
    }
    
    public function byEntity($entity)
    {
        $this->dbCriteria->addColumnCondition(array(
            'entity' => get_class($entity),
            'entity_id' => $entity->id,
        ));
        /** @todo Это не должно быть тут */
        $this->dbCriteria->with['author'] = array(
            'select' => 'id, gender, first_name, last_name, online, avatar_id, deleted',
            'with' => 'avatar',
        );

        return $this;
    }
    
}