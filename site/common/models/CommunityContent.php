<?php

/**
 * This is the model class for table "{{community__contents}}".
 *
 * The followings are the available columns in table '{{community__contents}}':
 * @property int $id
 * @property string $title
 * @property string $created
 * @property int $author_id
 * @property int $rubric_id
 * @property int $type_id
 * @property string $preview
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property int $by_happy_giraffe
 * @property int $uniqueness
 * @property int $full
 * @property int $rate
 * @property string $real_time
 * @property int $source_id
 * @property int $privacy
 *
 * The followings are the available model relations:
 *
 * @property User $author
 * @property CommunityRubric $rubric
 * @property CommunityContentType $type
 * @property CommunityPost $post
 * @property CommunityVideo $video
 * @property CommunityPhotoPost $photoPost
 * @property CommunityMorningPost $morningPost
 * @property CommunityContentGallery $gallery
 * @property Comment[] comments
 * @property CommunityContent source
 *
 * @method CommunityContent full()
 * @method CommunityContent findByPk()
 */
class CommunityContent extends HActiveRecord
{
    const TYPE_POST = 1;
    const TYPE_VIDEO = 2;
    const TYPE_PHOTO_POST = 3;
    const TYPE_MORNING = 4;
    const TYPE_STATUS = 5;

    const USERS_COMMUNITY = 999999;

    const PRIVACY_ALL = 0;
    const PRIVACY_FRIENDS = 0;
    //для модуля комментаторов
    public $visits = 0;

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
            array('title', 'length', 'max' => 50),
            array('meta_title, meta_description, meta_keywords', 'length', 'max' => 255),
            array('author_id, rubric_id, type_id', 'length', 'max' => 11),
            array('author_id, rubric_id, type_id', 'numerical', 'integerOnly' => true),
            array('rubric_id', 'exist', 'attributeName' => 'id', 'className' => 'CommunityRubric'),
            array('author_id', 'exist', 'attributeName' => 'id', 'className' => 'User'),
            array('by_happy_giraffe', 'boolean'),
            array('privacy', 'numerical', 'min' => 0, 'max' => 1),
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
            'source' => array(self::BELONGS_TO, 'CommunityContent', 'source_id'),
            'sourceCount' => array(self::STAT, 'CommunityContent', 'source_id'),
            'commentsCount' => array(self::STAT, 'Comment', 'entity_id', 'condition' => 'entity=:modelName', 'params' => array(':modelName' => get_class($this))),
            'comments' => array(self::HAS_MANY, 'Comment', 'entity_id', 'on' => 'entity=:modelName', 'params' => array(':modelName' => get_class($this))),
            'status' => array(self::HAS_ONE, 'CommunityStatus', 'content_id'),
            'video' => array(self::HAS_ONE, 'CommunityVideo', 'content_id'),
            'post' => array(self::HAS_ONE, 'CommunityPost', 'content_id'),
            'photoPost' => array(self::HAS_ONE, 'CommunityPhotoPost', 'content_id'),
            'author' => array(self::BELONGS_TO, 'User', 'author_id'),
            'remove' => array(self::HAS_ONE, 'Removed', 'entity_id', 'condition' => 'remove.entity = :entity', 'params' => array(':entity' => get_class($this))),
            'morningPost' => array(self::HAS_ONE, 'CommunityMorningPost', 'content_id'),
            'editor' => array(self::BELONGS_TO, 'User', 'editor_id'),
            'gallery' => array(self::HAS_ONE, 'CommunityContentGallery', 'content_id'),
            'favouritesCount' => array(self::STAT, 'Favourite', 'model_id', 'condition' => 'model_name=:modelName', 'params' => array(':modelName' => get_class($this))),
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
            'duplicate' => array(
                'class' => 'site.common.behaviors.DuplicateBehavior',
            )
        );
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

    public function defaultScope()
    {
        $alias = $this->getTableAlias(false, false);
        return array(
            'condition' => ($alias) ? $alias . '.removed = 0 AND type_id != 5' : 'removed = 0 AND type_id != 5',
        );
    }

    public function scopes()
    {
        return array(
            'full' => array(
                'with' => array(
                    'rubric',
                    'type' => array(
                        'select' => 'slug',
                    ),
                    'author' => array(
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


    /************************************************* Event handlers *************************************************/
    public function beforeDelete()
    {
        FriendEvent::postDeleted(($this->isFromBlog ? 'BlogContent' : 'CommunityContent'), $this->id);
        self::model()->updateByPk($this->id, array('removed' => 1));
        NotificationDelete::entityRemoved($this);
        Scoring::contentRemoved($this);

        return false;
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
            if ($this->type_id != self::TYPE_MORNING) {
                if ($this->isFromBlog) {
                    UserAction::model()->add($this->author_id, UserAction::USER_ACTION_BLOG_CONTENT_ADDED, array('model' => $this));
                } elseif ($this->rubric->community_id != Community::COMMUNITY_NEWS) {
                    UserAction::model()->add($this->author_id, UserAction::USER_ACTION_COMMUNITY_CONTENT_ADDED, array('model' => $this));
                }
            }

            if ($this->type_id == self::TYPE_STATUS)
                FriendEventManager::add(FriendEvent::TYPE_STATUS_UPDATED, array('model' => $this));

            if (in_array($this->type_id, array(self::TYPE_POST, self::TYPE_VIDEO))){
                Scoring::contentCreated($this);
                FriendEventManager::add(FriendEvent::TYPE_POST_ADDED, array('model' => $this));
            }
        }

        parent::afterSave();
    }

    /**
     * Возращает событие о новом посте
     * @return EventPost
     */
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

    /**
     * Посылает событие в что нового
     */
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


    /****************************************************** Url ******************************************************/
    /**
     * Возвращает параметры для создания url поста
     * @return array
     */
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
                if ($this->isValentinePost()) {
                    $route = '/valentinesDay/default/howToSpend';
                    $params = array();
                } elseif ($this->isFromBlog) {
                    $route = '/blog/default/view';
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

    /**
     * Возвращает url поста
     *
     * @param bool $comments ссылка на комментарии
     * @param bool $absolute абсолютный путь
     * @return string
     */
    public function getUrl($comments = false, $absolute = false)
    {
        list($route, $params) = $this->urlParams;

        if ($comments)
            $params['#'] = 'comment_list';

        $method = $absolute ? 'createAbsoluteUrl' : 'createUrl';
        return Yii::app()->$method($route, $params);
    }


    /*********************************************** Get dataProviders ************************************************/
    /**
     * Возвращает записи в клуб
     *
     * @param int $community_id id сообщества
     * @param int $rubric_id id рубрики
     * @param string $content_type_slug тип записей
     * @return CActiveDataProvider
     */
    public function getContents($community_id, $rubric_id, $content_type_slug)
    {
        $criteria = new CDbCriteria(array(
            'order' => 't.created DESC',
            'with' => array('rubric', 'type')
        ));

        $criteria->compare('community_id', $community_id);
        $criteria->scopes = array('active');

        if ($rubric_id !== null) {
            $criteria->addCondition('rubric.id = :rubric_id OR rubric.parent_id = :rubric_id');
            $criteria->params[':rubric_id'] = $rubric_id;
        }

        if ($content_type_slug !== null)
            $criteria->compare('slug', $content_type_slug);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Возвращает посты для блога
     *
     * @param int $user_id id атвора блога
     * @param int $rubric_id id рубрики
     * @return CActiveDataProvider
     */
    public function getBlogContents($user_id, $rubric_id)
    {
        $criteria = new CDbCriteria(array(
            'order' => 't.created DESC',
            'condition' => '(rubric.user_id IS NOT NULL OR t.type_id = 5) AND t.author_id = :user_id',
            'params' => array(':user_id' => $user_id),
            'with' => array('rubric'),
        ));

        if ($rubric_id !== null)
            $criteria->compare('rubric_id', $rubric_id);

        $criteria = $this->addPrivacyCondition($user_id, $criteria);

        $totalItemsCount = $this->active()->count($criteria);
        $criteria->with = array('rubric', 'author', 'author.avatar', 'commentsCount', 'type', 'sourceCount', 'favouritesCount');

        return new CActiveDataProvider($this->active(), array(
            'criteria' => $criteria,
            'totalItemCount' => $totalItemsCount
        ));
    }

    /**
     * Возвращает посты для мобильной версии сайта
     *
     * @param int $community_id id сообщества
     * @return CActiveDataProvider
     */
    public function getMobileContents($community_id)
    {
        $criteria = new CDbCriteria(array(
            'order' => 't.created DESC',
            'condition' => 'mobile_community_id = :community_id',
            'params' => array(':community_id' => $community_id),
        ));
        $criteria->addInCondition('type_id', array(self::TYPE_POST, self::TYPE_VIDEO));

        return new CActiveDataProvider($this->active()->full(), array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 3,
            ),
        ));
    }

    /**
     * @param int $user_id
     * @param CDbCriteria $criteria
     * @return CDbCriteria
     */
    public function addPrivacyCondition($user_id, $criteria)
    {
        if (Yii::app()->user->isGuest || !Friend::model()->areFriends($user_id, Yii::app()->user->id) && $user_id != Yii::app()->user->id)
            $criteria->addCondition('privacy = 0');

        return $criteria;
    }


    /************************************************ previous next ***************************************************/
    /**
     * Предыдущий пост
     * @return CommunityContent
     */
    public function getPrevPost()
    {
        if (!$this->getIsFromBlog()) {
            $prev = self::model()->cache(300)->find(
                array(
                    'select' => array('t.id', 't.title', 't.author_id', 't.rubric_id', 't.type_id'),
                    'condition' => 'rubric_id = :rubric_id AND t.id < :current_id',
                    'params' => array(':rubric_id' => $this->rubric_id, ':current_id' => $this->id),
                    'order' => 't.id DESC',
                )
            );
        } else {
            $prev = self::model()->cache(300)->find(
                array(
                    'select' => array('t.id', 't.title', 't.author_id', 't.rubric_id', 't.type_id'),
                    'condition' => 't.id < :current_id',
                    'params' => array(':current_id' => $this->id),
                    'order' => 't.id DESC',
                    'with' => array(
                        'rubric' => array(
                            'select' => array('id', 'user_id', 'community_id'),
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
     * Следующий пост
     * @return CommunityContent
     */
    public function getNextPost()
    {
        if (!$this->getIsFromBlog()) {
            $next = self::model()->cache(300)->find(
                array(
                    'select' => array('t.id', 't.title', 't.author_id', 't.rubric_id', 't.type_id'),
                    'condition' => 'rubric_id = :rubric_id AND t.id > :current_id',
                    'params' => array(':rubric_id' => $this->rubric_id, ':current_id' => $this->id),
                    'order' => 't.id',
                )
            );
        } else {
            $next = self::model()->cache(300)->find(
                array(
                    'select' => array('t.id', 't.title', 't.author_id', 't.rubric_id', 't.type_id'),
                    'condition' => 't.id > :current_id',
                    'params' => array(':current_id' => $this->id),
                    'order' => 't.id',
                    'with' => array(
                        'rubric' => array(
                            'select' => array('id', 'user_id', 'community_id'),
                            'condition' => 'user_id = :user_id',
                            'params' => array(':user_id' => $this->rubric->user_id),
                        ),
                    ),
                )
            );
        }

        return $next;
    }


    /**************************************************** checks *****************************************************/
    /**
     * Написан ли пост в блог
     * @return bool
     */
    public function getIsFromBlog()
    {
        return ($this->rubric_id !== null && $this->getRelated('rubric')->user_id !== null) || $this->type_id == 5;
    }

    /**
     * Может ли текущий пользователь редактировать пост
     * @return bool
     */
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
        return (Yii::app()->user->checkAccess('editCommunityContent', array('community_id' => $this->isFromBlog ? null : $this->rubric->community->id, 'user_id' => $this->author->id)));
    }

    /**
     * Может ли текущий пользователь удалить пост
     * @return bool
     */
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
        return (Yii::app()->user->checkAccess('removeCommunityContent', array('community_id' => $this->isFromBlog ? null : $this->rubric->community->id, 'user_id' => $this->author->id)));
    }

    /**
     * Является ли пост постом на День святого Валентина
     * @return bool
     */
    public function isValentinePost()
    {
        return isset($this->rubric) && isset($this->rubric->community_id) && $this->rubric->community_id == Community::COMMUNITY_VALENTINE;
    }

    /**
     * Является ли запись видео
     * @return bool
     */
    public function isVideo()
    {
        return $this->type_id == self::TYPE_VIDEO;
    }


    /************************************************ get content ***************************************************/
    /**
     * Возвращает описание поста для rss ленты
     * @return string
     */
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
                $output = CHtml::image($this->post->photo->getPreviewUrl(200, 200)) . $this->post->text;
                break;
            case 4:
                $output = $this->preview;
                foreach ($this->morningPost->photos as $p) {
                    $output .= CHtml::tag('p', array(), CHtml::image($p->url)) . CHtml::tag('p', array(), $p->text);
                }
                break;
        }

        return $output;
    }

    /**
     * Возвращает сущность привязанную к посту
     *
     * @return CommunityPost|CommunityVideo|CommunityStatus|CommunityPhotoPost
     */
    public function getContent()
    {
        return $this->{$this->type->slug};
    }

    /**
     * Возвращает краткой превью поста - картинку или текст
     *
     * @param int $width ширина картинки
     * @return string
     */
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

    /**
     * Возвращает url картинки для превью поста
     *
     * @param int $width ширина картинки
     * @return bool|string
     */
    public function getContentImage($width = 700)
    {
        if (!isset($this->content))
            return '';

        $photo = $this->content->getPhoto();
        return $photo ? $photo->getPreviewUrl($width, null) : false;
    }

    /**
     * Возвращает картинку для превью поста
     * @return null|AlbumPhoto
     */
    public function getPhoto()
    {
        if (!isset($this->content))
            return null;
        return $this->content->getPhoto();
    }

    /**
     * Возвращает укороченный текст поста
     * @param int $length длина строки
     * @param string $etc что показываем в конце
     * @return string
     */
    public function getContentText($length = 128, $etc = '...')
    {
        return Str::getDescription($this->getContent()->text, $length, $etc);
    }

    public function getNewPreviewText($length = 500, $etc = '...')
    {
        $text = strip_tags($this->getContent()->text);
        return Str::getDescription($text, $length, $etc);
    }


    /************************************************ other ***************************************************/
    /**
     * Последние кол-во комментариев к посту, нужен если объект инициализирован
     * как CommunityContent, однако на самом деле это BlogContent, в этом
     * случае relation не сработает
     *
     * @return int
     */
    public function getUnknownClassCommentsCount()
    {
        if ($this->getIsFromBlog()) {
            $model = BlogContent::model()->resetScope()->findByPk($this->id);
            return ($model) ? $model->commentsCount : 0;
        }
        return $this->commentsCount;
    }

    /**
     * Последние комментарии поста, нужен если объект инициализирован
     * как CommunityContent, однако на самом деле это BlogContent, в
     * этом случае relation не сработает
     *
     * @return Comment[]
     */
    public function getUnknownClassComments()
    {
        if ($this->getIsFromBlog()) {
            $model = BlogContent::model()->resetScope()->findByPk($this->id);
            return $model->comments;
        }
        return $this->comments;
    }

    /**
     * Возвращает несколько последних комментария поста с их авторами для показа
     * @param int $limit лимит комментаторов
     * @return Comment[]
     */
    public function getLastCommentators($limit = 3)
    {
        return Comment::model()->findAll(array(
            'with' => array(
                'author' => array(
                    'select' => 'id, avatar_id, gender, deleted, blocked',
                    'with' => 'avatar'
                ),
            ),
            'condition' => 'entity = :entity AND entity_id = :entity_id',
            'params' => array(':entity' => get_class($this), ':entity_id' => $this->id),
            'order' => 't.created DESC',
            'limit' => $limit,
            'group' => 't.author_id',
        ));
    }

    /**
     * Возвращает статус, связанный с постом
     * @return CommunityStatus
     */
    public function getStatus()
    {
        return CommunityStatus::model()->findByAttributes(array('content_id' => $this->id));
    }

    /**
     * Возвращает название статьи
     * @param int $length ограничение длины названия
     * @return string
     */
    public function getContentTitle($length = 150)
    {
        if ($this->type_id == self::TYPE_STATUS)
            return Str::truncate($this->getContent()->text, $length);
        return $this->title;
    }

    /**
     * Возвращает подсказку для вывода в списке уведомлений
     * @param bool $full полное описание или нет
     * @return string
     */
    public function getPowerTipTitle($full = false)
    {
        if ($this->type_id == self::TYPE_STATUS) {
            if ($this->author_id == Yii::app()->user->id)
                $t = "Мой статус";
            else
                $t = htmlentities("Статус пользователя \"" . $this->author->getFullName() . "\"", ENT_QUOTES, "UTF-8");
            if (!$full)
                return $t;

            return $t . htmlentities('<br><span class=\'color-gray\' > ' . $this->getContentTitle(100) . '</span>', ENT_QUOTES, "UTF-8");
        } elseif ($this->getIsFromBlog()) {
            if ($this->author_id == Yii::app()->user->id)
                $t = "Мой блог";
            else
                $t = htmlentities("Блог пользователя \"" . $this->author->getFullName() . "\"", ENT_QUOTES, "UTF-8");
        } else
            $t = htmlentities(("Клуб <span class='color-category " . $this->rubric->community->css_class . "'>" . $this->rubric->community->title . "</span>"), ENT_QUOTES, "UTF-8");
        if (!$full)
            return $t;

        return $t . htmlentities('<br>Запись <span class=\'color-gray\' > ' . $this->getContentTitle() . '</span>', ENT_QUOTES, "UTF-8");
    }

    /**
     * Возвращает посты с галереями из этого же сообщества
     * @param int $limit
     * @return CommunityContent[]
     */
    public function OtherCommunityGalleries($limit = 3)
    {
        $criteria = new CDbCriteria;
        $criteria->with = array('rubric', 'gallery', 'type', 'post');
        $criteria->condition = 'rubric.community_id = :community AND gallery.id IS NOT NULL AND t.id != :id';
        $criteria->params = array(
            ':community' => $this->rubric->community_id,
            ':id' => $this->id,
        );
        $criteria->limit = $limit;
        $criteria->order = 'rand()';

        return CommunityContent::model()->findAll($criteria);
    }

    /**
     * Возвращает пост для отображения
     * @return CommunityContent
     */
    public function getSourceContent()
    {
        return empty($this->source_id) ? $this : $this->source;
    }

    /**
     * Прикрепить запись блога сверху
     * @return bool
     */
    public function attachBlogPost()
    {
        if (!empty($this->real_time)) {
            $this->created = $this->real_time;
            $this->real_time = null;
            return $this->update(array('created', 'real_time'));
        } else {
            //unAttach other user posts
            $attachedPosts = CommunityContent::model()->findAll(
                'real_time IS NOT NULL AND author_id=:author_id',
                array(':author_id' => $this->author_id)
            );
            foreach ($attachedPosts as $attachedPost) {
                $attachedPost->created = $attachedPost->real_time;
                $attachedPost->real_time = null;
                $attachedPost->update(array('created', 'real_time'));
            }
            //attach current
            $this->real_time = $this->created;
            $this->created = date("Y-m-d H:i:s", strtotime('+20 years'));
            return $this->update(array('created', 'real_time'));
        }
    }

    /**
     * Настройки записи в блог
     * @return array
     */
    public function getSettingsViewModel()
    {
        return array(
            'id' => $this->id,
            'attached' => $this->real_time != null,
            'privacy' => (int)$this->privacy,
        );
    }

    public function restore()
    {
        return self::model()->updateByPk($this->id, array('removed' => 0)) > 0;
    }

    /**
     * Возвращает массив репостов за последние 24 часа
     * @return array
     */
    public function findLastDayReposts()
    {
        $result = array();
        $t = microtime(true);
        $reposts = Yii::app()->db->createCommand()
            ->select('*, count(source_id) as count')
            ->from($this->tableName())
            ->group('source_id')
            ->where('created > "' . date("Y-m-d H:i:s", strtotime('-1 day')) . '" AND source_id IS NOT NULL')
            ->queryAll();
        echo microtime(true) - $t . "\n";
        echo count($reposts) . "\n";

        foreach ($reposts as $repost) {
            $source = CommunityContent::model()->findByPk($repost['source_id']);
            if ($source) {
                $author_id = $source->author_id;
                if (!isset($result[$author_id]))
                    $result[$author_id]['CommunityContent'] = array();

                $result[$author_id]['CommunityContent'][$repost['source_id']] = $repost['count'];
            }
        }

        return $result;
    }
}