<?php

/**
 * This is the model class for table "{{community__contents}}".
 *
 * The followings are the available columns in table '{{community__contents}}':
 * @property string $id
 * @property string $title
 * @property string $created
 * @property string $author_id
 * @property string $rubric_id
 * @property string $type_id
 * @property string $preview
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property integer $by_happy_giraffe
 * @property string $uniqueness
 * @property string $full
 *
 * The followings are the available model relations:
 *
 * @property User $contentAuthor
 * @property CommunityRubric $rubric
 * @property CommunityContentType $type
 * @property CommunityPost $post
 * @property CommunityVideo $video
 * @property CommunityPhotoPost $photoPost
 * @property userPhotos[] $userPhotos
 * @property CommunityContentGallery $gallery
 * @property Comment[] comments
 *
 * @method CommunityContent full()
 * @method CommunityContent findByPk()
 */
class CommunityContent extends HActiveRecord
{
    const TYPE_POST = 1;
    const TYPE_VIDEO = 2;
    const TYPE_TRAVEL = 3;
    const TYPE_PHOTO_POST = 4;
    const TYPE_STATUS = 5;

    const USERS_COMMUNITY = 999999;

    /**
     * Returns the static model of the specified AR class.
     * @return CommunityContent the static model class
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
        return 'community__contents';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title', 'required', 'except' => 'status'),
            array('author_id, type_id', 'required'),
            array('rubric_id', 'required', 'on' => 'default'),
            array('title, meta_title, meta_description, meta_keywords', 'length', 'max' => 255),
            array('author_id, rubric_id, type_id', 'length', 'max' => 11),
            array('author_id, rubric_id, type_id', 'numerical', 'integerOnly' => true),
            array('rubric_id', 'exist', 'attributeName' => 'id', 'className' => 'CommunityRubric'),
            array('author_id', 'exist', 'attributeName' => 'id', 'className' => 'User'),
            array('by_happy_giraffe', 'boolean'),
            array('preview', 'safe'),

            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, by_happy_giraffe, title, meta_title, meta_description, meta_keywords, created, author_id, rubric_id, type_id', 'safe', 'on' => 'search'),
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
            'rubric' => array(self::BELONGS_TO, 'CommunityRubric', 'rubric_id'),
            'type' => array(self::BELONGS_TO, 'CommunityContentType', 'type_id'),
            'commentsCount' => array(self::STAT, 'Comment', 'entity_id', 'condition' => 'entity=:modelName', 'params' => array(':modelName' => get_class($this))),
            'comments' => array(self::HAS_MANY, 'Comment', 'entity_id', 'on' => 'entity=:modelName', 'params' => array(':modelName' => get_class($this))),
            'status' => array(self::HAS_ONE, 'CommunityStatus', 'content_id', 'on' => 'type_id = 5'),
            'travel' => array(self::HAS_ONE, 'CommunityTravel', 'content_id', 'on' => 'type_id = 3'),
            'video' => array(self::HAS_ONE, 'CommunityVideo', 'content_id', 'on' => 'type_id = 2'),
            'post' => array(self::HAS_ONE, 'CommunityPost', 'content_id', 'on' => 'type_id = 1'),
            'contentAuthor' => array(self::BELONGS_TO, 'User', 'author_id'),
            'author' => array(self::BELONGS_TO, 'User', 'author_id'),
            'remove' => array(self::HAS_ONE, 'Removed', 'entity_id', 'condition' => 'remove.entity = :entity', 'params' => array(':entity' => get_class($this))),
            'photoPost' => array(self::HAS_ONE, 'CommunityPhotoPost', 'content_id'),
            'userPhotos' => array(self::HAS_MANY, 'UserPhoto', 'content_id'),
            'editor' => array(self::BELONGS_TO, 'User', 'editor_id'),
            'gallery' => array(self::HAS_ONE, 'CommunityContentGallery', 'content_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Заголовок',
            'created' => 'Created',
            'author_id' => 'Автор',
            'rubric_id' => 'Рубрика',
            'type_id' => 'Type',
            'by_happy_giraffe' => 'От Весёлого Жирафа',
            'meta_title' => 'Заголовок страницы',
        );
    }

    public function behaviors()
    {
        return array(
            'withRelated' => array(
                'class' => 'site.common.extensions.wr.WithRelatedBehavior',
            ),
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
            ),
            'purified' => array(
                'class' => 'site.common.behaviors.PurifiedBehavior',
                'attributes' => array('preview'),
                'options' => array(
                    'AutoFormat.Linkify' => true,
                ),
            ),
            'pingable' => array(
                'class' => 'site.common.behaviors.PingableBehavior',
            ),
            'duplicate'=>array(
                'class' => 'site.common.behaviors.DuplicateBehavior',
            )
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
        $criteria->compare('title', $this->title, true);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('author_id', $this->author_id, true);
        $criteria->compare('rubric_id', $this->rubric_id, true);
        $criteria->compare('type_id', $this->type_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 30),
        ));
    }

//    public function community($community_id)
//    {
//        $this->getDbCriteria()->mergeWith(array(
//            'with' => array(
//                'rubric' => array(
//                    'select' => FALSE,
//                    'with' => array(
//                        'community' => array(
//                            'select' => FALSE,
//                            'condition' => 'community_id=:community_id',
//                            'params' => array(':community_id' => $community_id),
//                        )
//                    ),
//                ),
//                'post',
//                'video',
//                'commentsCount',
//                'travel' => array(
//                    'with' => array(
//                        'waypoints' => array(
//                            'with' => array(
//                                'city',
//                                'country',
//                            ),
//                        ),
//                    )
//                ),
//            ),
//            'order' => 't.id DESC',
//        ));
//        return $this;
//    }

    public function type($type_id)
    {
        if ($type_id !== null) {
            $this->getDbCriteria()->mergeWith(array(
                'with' => array(
                    'rubric' => array(
                        'condition' => 'type_id=:type_id',
                        'params' => array(':type_id' => $type_id),
                    ),
                ),
            ));
        }
        return $this;
    }

    public function rubric($rubric_id)
    {
        if ($rubric_id !== null) {
            $this->getDbCriteria()->mergeWith(array(
                'with' => array(
                    'rubric' => array(
                        'condition' => 'rubric_id=:rubric_id',
                        'params' => array(':rubric_id' => $rubric_id),
                    ),
                ),
            ));
        }
        return $this;
    }

    /*public function scopes()
     {
         return array(
             'view' => array(
                 'with' => array(
                     'rubric' => array(
                         'with' => array(
                             'community' => array(
                                 'with' => array(
                                     'rubrics',
                                 ),
                             ),
                         ),
                     ),
                     'post',
                     'video',
                     'commentsCount',
                     'contentAuthor',
                     'travel' => array(
                         'with' => array(
                             'waypoints' => array(
                                 'with' => array(
                                     'city',
                                     'country',
                                 ),
                             ),
                         )
                     ),
                 ),
             ),
             'active'=>array(
                 'condition'=>'removed=0'
             )
         );
     }*/

    public function beforeDelete()
    {
        self::model()->updateByPk($this->id, array('removed' => 1));

        if ($this->isFromBlog && count($this->contentAuthor->blogPosts) == 0) {
            UserScores::removeScores($this->author_id, ScoreAction::ACTION_FIRST_BLOG_RECORD, 1, $this);
        } else
            UserScores::removeScores($this->author_id, ScoreAction::ACTION_RECORD, 1, $this);
        //закрываем сигнал
        UserSignal::closeRemoved($this);

        return false;
    }

    public function purify($t)
    {
        $p = new CHtmlPurifier();
        $p->options = array(
            'URI.AllowedSchemes' => array(
                'http' => true,
                'https' => true,
            ),
            'HTML.Nofollow' => true,
            'HTML.TargetBlank' => true,
            'HTML.AllowedComments' => array('more' => true),

        );
        $text = $p->purify($t);
        $pos = strpos($text, '<!--more-->');
        $preview = $pos === false ? $text : substr($text, 0, $pos);
        $preview = $p->purify($preview);
        $this->preview = $preview;
        $this->save();
        unset($p);
        return $text;
    }

    public function beforeSave()
    {
        $this->title = strip_tags($this->title);
        if ($this->isNewRecord) {
            $this->last_updated = new CDbExpression('NOW()');
        }
        return parent::beforeSave();
    }

    public function afterSave()
    {
        if ($this->isNewRecord && $this->type_id != 4) {
            Yii::app()->cache->set('activityLastUpdated', time());
        }

        if (get_class(Yii::app()) == 'CConsoleApplication')
            return parent::afterSave();

        if ($this->isNewRecord) {
            if ($this->contentAuthor->isNewComer()) {
                $signal = new UserSignal();
                $signal->user_id = (int)$this->author_id;
                $signal->item_id = (int)$this->id;
                $signal->item_name = 'CommunityContent';

                if ($this->isFromBlog)
                    $signal->signal_type = UserSignal::TYPE_NEW_BLOG_POST;
                else {
                    if ($this->type->slug == 'video')
                        $signal->signal_type = UserSignal::TYPE_NEW_USER_VIDEO;
                    else
                        $signal->signal_type = UserSignal::TYPE_NEW_USER_POST;
                }

                if (!$signal->save()) {
                    Yii::log('NewComers signal not saved', 'warning', 'application');
                }
            }

            if ($this->rubric_id !== null) {
                if ($this->isFromBlog && count($this->contentAuthor->blogPosts) == 1) {
                    UserScores::addScores($this->author_id, ScoreAction::ACTION_FIRST_BLOG_RECORD, 1, $this);
                } else
                    UserScores::addScores($this->author_id, ScoreAction::ACTION_RECORD, 1, $this);
            }

            if ($this->type_id != 4) {
                if ($this->isFromBlog) {
                    UserAction::model()->add($this->author_id, UserAction::USER_ACTION_BLOG_CONTENT_ADDED, array('model' => $this));
                } elseif ($this->rubric->community_id != Community::COMMUNITY_NEWS) {
                    UserAction::model()->add($this->author_id, UserAction::USER_ACTION_COMMUNITY_CONTENT_ADDED, array('model' => $this));
                }
            }

            //send signals to commentator panel
            if (Yii::app()->user->checkAccess('commentator_panel')) {
                Yii::import('site.frontend.modules.signal.models.*');
                CommentatorWork::getCurrentUser()->refreshCurrentDayPosts();
                $comet = new CometModel;
                if ($this->isFromBlog)
                    $comet->send(Yii::app()->user->id, array(
                        'update_part' => CometModel::UPDATE_BLOG,
                    ), CometModel::TYPE_COMMENTATOR_UPDATE);
                else
                    $comet->send(Yii::app()->user->id, array(
                        'update_part' => CometModel::UPDATE_CLUB,
                    ), CometModel::TYPE_COMMENTATOR_UPDATE);
            }

            if ($this->type_id == 5)
                FriendEventManager::add(FriendEvent::TYPE_STATUS_UPDATED, array('model' => $this));

            if (in_array($this->type_id, array(1, 2)))
                FriendEventManager::add(FriendEvent::TYPE_POST_ADDED, array('model' => $this));
        }

        parent::afterSave();
    }

    public function getUrlParams()
    {
        switch ($this->type_id) {
            case 4:
                $route = '/morning/view';
                $params = array(
                    'id' => $this->id,
                );
                break;
            default:
                if ($this->isValentinePost()){
                    $route = '/valentinesDay/default/howToSpend';
                    $params = array();
                }elseif ($this->isFromBlog) {
                    $route = '/blog/view';
                    $params = array(
                        'user_id' => $this->author_id,
                        'content_id' => $this->id,
                    );
                } else {
                    $route = '/community/view';
                    $params = array(
                        'community_id' => $this->rubric->community_id,
                        'content_type_slug' => $this->type->slug,
                        'content_id' => $this->id,
                    );
                }
        }

        return array($route, $params);
    }

    public function getUrl($comments = false, $absolute = false)
    {
        list($route, $params) = $this->urlParams;

        if ($comments)
            $params['#'] = 'comment_list';

        $method = $absolute ? 'createAbsoluteUrl' : 'createUrl';
        return Yii::app()->$method($route, $params);
    }

    public function scopes()
    {
        return array(
            'full' => array(
                'with' => array(
                    'rubric' => array(
                        'with' => array(
                            'community',
                        ),
                    ),
                    'type' => array(
                        'select' => 'slug',
                    ),
                    'post',
                    'video',
                    'travel',
                    'status',
                    'commentsCount',
                    'contentAuthor' => array(
                        'select' => 'id, gender, first_name, last_name, online, avatar_id, deleted',
                    ),
                ),
            ),
            'community' => array(
                'with' => array(
                    'rubric',
                ),
                'condition' => 'rubric.community_id IS NOT NULL',
            ),
            'blog' => array(
                'with' => array(
                    'rubric',
                ),
                'condition' => 'rubric.user_id IS NOT NULL',
            ),
            'active' => array(
                'condition' => 't.removed = 0',
            ),
        );
    }

    public function getContents($community_id, $rubric_id, $content_type_slug)
    {
        $criteria = new CDbCriteria(array(
            'order' => 't.created DESC'
        ));

        $criteria->compare('community_id', $community_id);

        if ($rubric_id !== null) {
            $criteria->with = 'rubric';
            $criteria->addCondition('rubric.id = :rubric_id OR rubric.parent_id = :rubric_id');
            $criteria->params[':rubric_id'] = $rubric_id;
        }

        if ($content_type_slug !== null) {
            $criteria->compare('slug', $content_type_slug);
        }

        return new CActiveDataProvider($this->active()->full(), array(
            'criteria' => $criteria,
        ));
    }

    public function getBlogContents($user_id, $rubric_id)
    {
        $criteria = new CDbCriteria(array(
            'order' => 't.created DESC',
            'condition' => '(rubric.user_id IS NOT NULL OR t.type_id = 5) AND t.author_id = :user_id',
            'params' => array(':user_id' => $user_id),
        ));

        if ($rubric_id !== null) {
            $criteria->compare('rubric_id', $rubric_id);
        }

        return new CActiveDataProvider($this->active()->full(), array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @return CommunityContent
     */
    public function getPrevPost()
    {
        if (!$this->isFromBlog) {
            $prev = $this->full()->find(
                array(
                    'condition' => 'rubric_id = :rubric_id AND t.id < :current_id',
                    'params' => array(':rubric_id' => $this->rubric_id, ':current_id' => $this->id),
                    'limit' => 2,
                    'order' => 't.id DESC',
                )
            );
        } else {
            $prev = $this->full()->find(
                array(
                    'condition' => 't.id < :current_id',
                    'params' => array(':current_id' => $this->id),
                    'limit' => 2,
                    'order' => 't.id DESC',
                    'with' => array(
                        'rubric' => array(
                            'condition' => 'user_id = :user_id',
                            'params' => array(':user_id' => $this->rubric->user_id),
                        ),
                    ),
                )
            );
        }

        return $prev;
    }

    /**
     * @return CommunityContent
     */
    public function getNextPost()
    {
        if (!$this->isFromBlog) {
            $next = $this->full()->find(
                array(
                    'condition' => 'rubric_id = :rubric_id AND t.id > :current_id',
                    'params' => array(':rubric_id' => $this->rubric_id, ':current_id' => $this->id),
                    'order' => 't.id',
                )
            );
        } else {
            $next = $this->full()->find(
                array(
                    'condition' => 't.id > :current_id',
                    'params' => array(':current_id' => $this->id),
                    'order' => 't.id',
                    'with' => array(
                        'rubric' => array(
                            'condition' => 'user_id = :user_id',
                            'params' => array(':user_id' => $this->rubric->user_id),
                        ),
                    ),
                )
            );
        }

        return $next;
    }


    public function getContent()
    {
        return $this->{$this->type->slug};
    }

    public function getIsFromBlog()
    {
        return ($this->rubric_id !== null && $this->getRelated('rubric')->user_id !== null) || $this->type_id == 5;
    }

    public function defaultScope()
    {
        $alias = $this->getTableAlias(false, false);
        return array(
            'condition' => ($alias) ? $alias . '.removed = 0 AND type_id != 5' : 'removed = 0 AND type_id != 5',
        );
    }

    public function getShort($width = 700)
    {
        switch ($this->type_id) {
            case 1:
                return ($image = $this->getContentImage($width)) ? CHtml::image($image, $this->title) : $this->getContentText();
            case 2:
                if ($this->video->getPhoto() !== null)
                    return '<img src="' . $this->video->getPhoto()->getPreviewUrl($width, null, Image::WIDTH) . '" alt="' . $this->title . '" />';
        }
        return '';
    }

    public function getContentImage($width = 700)
    {
        if (!isset($this->content))
            return '';

        $photo = $this->content->getPhoto();
        return $photo ? $photo->getPreviewUrl($width, null, Image::WIDTH) : false;
    }

    public function getContentText($length = 128)
    {
        return Str::getDescription($this->content->text, $length);
    }

    public function canEdit()
    {
        if ($this->rubric->community_id == Community::COMMUNITY_NEWS) {
            return Yii::app()->authManager->checkAccess('news', Yii::app()->user->id);
        }

        if (Yii::app()->user->model->role == 'user') {
            if ($this->author_id == Yii::app()->user->id)
                return true;
            return false;
        }
        return (Yii::app()->user->checkAccess('editCommunityContent', array('community_id' => $this->isFromBlog ? null : $this->rubric->community->id, 'user_id' => $this->contentAuthor->id)));
    }

    public function canRemove()
    {
        if ($this->rubric->community_id == Community::COMMUNITY_NEWS) {
            return Yii::app()->authManager->checkAccess('news', Yii::app()->user->id);
        }

        if (Yii::app()->user->model->role == 'user') {
            if ($this->author_id == Yii::app()->user->id)
                return true;
            return false;
        }
        return (Yii::app()->user->checkAccess('removeCommunityContent', array('community_id' => $this->isFromBlog ? null : $this->rubric->community->id, 'user_id' => $this->contentAuthor->id)));
    }

    public function getRssContent()
    {
        switch ($this->type_id) {
            case 1:
                $output = $this->post->text;
                break;
            case 2:
                $video = new Video($this->video->link);
                $output = CHtml::image($video->image) . $this->video->text;
                break;
            case 3:
                $output = $this->travel->text;
                break;
            case 4:
                $output = $this->preview;
                foreach ($this->photoPost->photos as $p) {
                    $output .= CHtml::tag('p', array(), CHtml::image($p->url)) . CHtml::tag('p', array(), $p->text);
                }
                break;
        }

        return $output;
    }

    public function getUnknownClassCommentsCount()
    {
        if ($this->getIsFromBlog()) {
            $model = BlogContent::model()->findByPk($this->id);
            return ($model) ? $model->commentsCount : 0;
        }
        return $this->commentsCount;
    }

    public function getUnknownClassComments()
    {
        if ($this->getIsFromBlog()) {
            $model = BlogContent::model()->findByPk($this->id);
            return $model->comments;
        }
        return $this->comments;
    }

    public function getLastCommentators($limit = 3)
    {
        return Comment::model()->with('author', 'author.avatar')->findAll(array(
            'condition' => 'entity = :entity AND entity_id = :entity_id',
            'params' => array(':entity' => get_class($this), ':entity_id' => $this->id),
            'order' => 't.created DESC',
            'limit' => $limit,
            'group' => 't.author_id',
        ));
    }

    public function getStatus()
    {
        return CommunityStatus::model()->findByAttributes(array('content_id' => $this->id));
    }

    public function getEvent()
    {
        $row = array(
            'id' => $this->id,
            'last_updated' => time(),
            'type' => Event::EVENT_POST,
        );

        $event = Event::factory(Event::EVENT_POST);
        $event->attributes = $row;
        return $event;
    }

    public function sendEvent()
    {
        if (isset($this->rubric) && $this->rubric->community_id != Community::COMMUNITY_NEWS) {
            $event = $this->event;
            $params = array(
                'blockId' => $event->blockId,
                'code' => $event->code,
            );

            $comet = new CometModel;
            $comet->send('whatsNewIndex', $params, CometModel::WHATS_NEW_UPDATE);
            if ($this->isFromBlog) {
                $comet->send('whatsNewBlogs', $params, CometModel::WHATS_NEW_UPDATE);

                $friends = $this->author->getFriendsModels();

                foreach ($friends as $f)
                    $comet->send('whatsNewBlogsUser' . $f->id, $params, CometModel::WHATS_NEW_UPDATE);
            } else {
                $comet->send('whatsNewClubs', $params, CometModel::WHATS_NEW_UPDATE);

                $sql = 'SELECT user_id FROM user__users_communities WHERE community_id = :community_id';
                $command = Yii::app()->db->createCommand($sql);
                $command->bindValue(':community_id', $this->rubric->community_id);
                $ids = $command->queryColumn();

                foreach ($ids as $id)
                    $comet->send('whatsNewClubsUser' . $id, $params, CometModel::WHATS_NEW_UPDATE);
            }
        }
    }

    /**
     * Является ли пост постом на День святого Валентина
     * @return bool
     */
    public function isValentinePost()
    {
        return isset($this->rubric) && isset($this->rubric->community_id) && $this->rubric->community_id == Community::COMMUNITY_VALENTINE;
    }

    public function getMobileContents($community_id)
    {
        $criteria = new CDbCriteria(array(
            'order' => 't.created DESC',
            //'condition' => 'mobile_community_id = :community_id',
            //'params' => array(':community_id' => $community_id),
        ));
        $criteria->addInCondition('type_id', array(self::TYPE_POST, self::TYPE_VIDEO));

        return new CActiveDataProvider($this->active()->full(), array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 3,
            ),
        ));
    }
}