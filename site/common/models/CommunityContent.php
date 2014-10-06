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
 * @property string $meta_description_auto
 * @property int $by_happy_giraffe
 * @property int $uniqueness
 * @property int $full
 * @property int $rate
 * @property string $real_time
 * @property int $source_id
 * @property int $privacy
 * @property string $powerTipTitle Подсказка для вывода в списках
 *
 * The followings are the available model relations:
 *
 * @property User $author
 * @property CommunityRubric $rubric
 * @property CommunityContentType $type
 * @property CommunityPost $post
 * @property CommunityVideo $video
 * @property CommunityPhotoPost $photoPost
 * @property CommunityMorningPost $morning
 * @property CommunityContentGallery $gallery
 * @property Comment[] comments
 * @property CommunityContent source
 *
 * @method CommunityContent full()
 * @method CommunityContent findByPk()
 */
class CommunityContent extends HActiveRecord implements IPreview
{
    const TYPE_POST = 1;
    const TYPE_VIDEO = 2;
    const TYPE_PHOTO_POST = 3;
    const TYPE_MORNING = 4;
    const TYPE_STATUS = 5;
    const TYPE_REPOST = 6;
    const TYPE_QUESTION = 7;
    // Используется в CookRecipe::getType_id
    const TYPE_RECIPE = 8;
    // Используется в AlbumPhoto::getType_id
    const TYPE_PHOTO = 9;

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
            array('title', 'filter', 'filter' => array('\site\frontend\components\TrimFilter', 'trimTitle')),
            array('title', 'required', 'except' => 'status'),
            array('type_id', 'required'),
            array('rubric_id', 'required', 'on' => 'default_club'),
            array('title', 'length', 'max' => 100),
            array('meta_title, meta_description, meta_keywords', 'length', 'max' => 255),
            array('rubric_id, type_id', 'length', 'max' => 11),
            array('rubric_id, type_id', 'numerical', 'integerOnly' => true),
            array('rubric_id', 'exist', 'attributeName' => 'id', 'className' => 'CommunityRubric'),
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
            'question' => array(self::HAS_ONE, 'CommunityQuestion', 'content_id'),
            'photoPost' => array(self::HAS_ONE, 'CommunityPhotoPost', 'content_id'),
            'author' => array(self::BELONGS_TO, 'User', 'author_id'),
            'remove' => array(self::HAS_ONE, 'Removed', 'entity_id', 'condition' => 'remove.entity = :entity', 'params' => array(':entity' => get_class($this))),
            'morning' => array(self::HAS_ONE, 'CommunityMorningPost', 'content_id'),
            'editor' => array(self::BELONGS_TO, 'User', 'editor_id'),
            'gallery' => array(self::HAS_ONE, 'CommunityContentGallery', 'content_id'),
            'favouritesCount' => array(self::STAT, 'Favourite', 'model_id', 'condition' => 'model_name=:modelName', 'params' => array(':modelName' => get_class($this))),
            'contestWork' => array(self::HAS_ONE, 'CommunityContestWork', 'content_id'),
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
        if($this->scenario == 'advEditor')
            return array();
        return array(
            'ContentBehavior' => array(
                'class' => 'site\frontend\modules\notifications\behaviors\ContentBehavior',
            ),
            'withRelated' => array(
                'class' => 'site.common.extensions.wr.WithRelatedBehavior',
            ),
            'HTimestampBehavior' => array(
                'class' => 'HTimestampBehavior',
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
            'antispam' => array(
                'class' => 'site.frontend.modules.antispam.behaviors.AntispamBehavior',
                'interval' => 7 * 60,
                'maxCount' => 3,
            ),
            'softDelete' => array(
                'class' => 'site.common.behaviors.SoftDeleteBehavior',
            ),
//            'duplicate' => array(
//                'class' => 'site.common.behaviors.DuplicateBehavior',
//            ),
//            'yandexwm' => array(
//                'class' => '\site\frontend\modules\seo\components\YandexOriginalTextBehavior',
//            ),
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
        self::model()->deleteAll('source_id=:removed_id', array(':removed_id' => $this->id));
        Scoring::contentRemoved($this);

        return parent::beforeDelete();
    }

    public function beforeSave()
    {
        if($this->scenario == 'advEditor')
            return parent::beforeSave();
        if (empty($this->rubric_id))
            $this->rubric_id = CommunityRubric::getDefaultUserRubric($this->author_id);

        $this->title = strip_tags($this->title);
        if ($this->isNewRecord) {
            $this->last_updated = new CDbExpression('NOW()');
        }

        //generate meta description
        if ($this->type_id != self::TYPE_MORNING) {
            $meta_description_auto = Str::getDescription($this->getContent()->text);
            if (!empty($meta_description_auto)) {
                if ($this->isNewRecord)
                    $meta_exist = Yii::app()->db->createCommand()->select('id')->from('community__contents')
                        ->where('meta_description_auto=:meta_description_auto', array(':meta_description_auto' => $meta_description_auto))
                        ->queryScalar();
                else
                    $meta_exist = Yii::app()->db->createCommand()->select('id')->from('community__contents')
                        ->where('id < :id AND meta_description_auto=:meta_description_auto',
                            array(':meta_description_auto' => $meta_description_auto, ':id' => $this->id))
                        ->queryScalar();
                if (empty($meta_exist))
                    $this->meta_description_auto = $meta_description_auto;
            }
        }

        return parent::beforeSave();
    }

    public function afterSave()
    {
        if ($this->scenario == 'advEditor')
            return parent::beforeSave();
        if ($this->isNewRecord && $this->type_id != 4) {
            Yii::app()->cache->set('activityLastUpdated', time());
        }

        if (get_class(Yii::app()) == 'CConsoleApplication')
            return parent::afterSave();

        if ($this->isNewRecord) {
            if ($this->type_id != self::TYPE_MORNING) {
                if ($this->getIsFromBlog()) {
                    UserAction::model()->add($this->author_id, UserAction::USER_ACTION_BLOG_CONTENT_ADDED, array('model' => $this));
                } elseif ($this->rubric->community_id != Community::COMMUNITY_NEWS) {
                    UserAction::model()->add($this->author_id, UserAction::USER_ACTION_COMMUNITY_CONTENT_ADDED, array('model' => $this));
                }
            }

            if ($this->type_id == self::TYPE_STATUS)
                FriendEventManager::add(FriendEvent::TYPE_STATUS_UPDATED, array('model' => $this));

            if (in_array($this->type_id, array(self::TYPE_POST, self::TYPE_VIDEO, self::TYPE_PHOTO_POST))) {
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
                    $route = '/community/default/view';
                    $params = array(
                        'forum_id' => $this->rubric->community_id,
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
     * Возвращает записи в форум
     *
     * @param int $forum_id id форума
     * @param int $rubric_id id рубрики
     * @return CActiveDataProvider
     */
    public function getContents($forum_id, $rubric_id)
    {
        $criteria = new CDbCriteria();
        $criteria->order = 'created DESC';
        $criteria->with = array('rubric');
        $criteria->compare('community_id', $forum_id);
        $criteria->scopes = array('active');

        if ($rubric_id !== null) {
            $criteria->addCondition('rubric.id = :rubric_id OR rubric.parent_id = :rubric_id');
            $criteria->params[':rubric_id'] = $rubric_id;
        }
        $totalItemsCount = $this->count($criteria);

        $criteria->with = array('rubric', 'type', 'commentsCount', 'sourceCount');
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'totalItemCount' => $totalItemsCount
        ));
    }

    /**
     * Возвращает все записи в раздел
     *
     * @param int $section_id id раздела
     * @return CActiveDataProvider
     */
    public function getSectionContents($section_id)
    {
        $criteria = new CDbCriteria();
        $criteria->order = 't.created DESC';
        $criteria->addCondition('club.id != 21 AND club.id != 22 AND club.id != 19');
        $criteria->compare('section_id', $section_id);
        $criteria->scopes = array('active');
        $criteria->with = array('rubric', 'rubric.community', 'rubric.community.club');
        $totalItemsCount = $this->count($criteria);

        $criteria->with = array('rubric', 'rubric.community', 'rubric.community.club', 'type', 'commentsCount', 'sourceCount');
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'totalItemCount' => $totalItemsCount
        ));
    }

    /**
     * Возвращает все записи в раздел
     *
     * @param int $club_id id раздела
     * @return CActiveDataProvider
     */
    public function getClubContents($club_id, $typeId = null)
    {
        $criteria = new CDbCriteria();
        $criteria->order = 't.created DESC';
        $criteria->compare('club_id', $club_id);
        $criteria->scopes = array('active');
        $criteria->with = array('rubric', 'rubric.community');
        if ($typeId !== null)
            $criteria->compare('t.type_id', $typeId);
        $totalItemsCount = $this->count($criteria);

        $criteria->with = array('rubric', 'rubric.community', 'type', 'commentsCount', 'sourceCount');
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'totalItemCount' => $totalItemsCount
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
            'order' => 't.pinned DESC, t.created DESC',
            'condition' => 'rubric.user_id IS NOT NULL AND t.author_id = :user_id',
            'params' => array(':user_id' => $user_id),
            'with' => array('rubric'),
        ));

        if ($rubric_id !== null)
            $criteria->compare('rubric_id', $rubric_id);

        $criteria = $this->addPrivacyCondition($user_id, $criteria);

        $totalItemsCount = $this->resetScope()->active()->count($criteria);
        $criteria->with = array('rubric', 'author', 'author.avatar', 'type', 'commentsCount', 'sourceCount');

        return new CActiveDataProvider($this->resetScope()->active(), array(
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
            'scopes' => array('active'),
            'with' => array(
                'rubric' => array(
                    'with' => array(
                        'community',
                    ),
                ),
            ),
            'order' => 't.created DESC',
            'condition' => 'mobile_community_id = :community_id',
            'params' => array(':community_id' => $community_id),
        ));
        $criteria->addInCondition('type_id', array(self::TYPE_POST, self::TYPE_VIDEO));

        return new CActiveDataProvider($this, array(
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

    /**
     * Возвращает контент пользователя для его ленты
     *
     * @param User $user
     * @param bool $hide_last_status
     * @return CActiveDataProvider
     */
    public function getUserContent($user, $hide_last_status = true)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 't.author_id = :user_id';
        $criteria->params = array(':user_id' => $user->id);
        if ($hide_last_status) {
            $last_status = $user->getLastStatus();
            if ($last_status) {
                $criteria->condition .= ' AND t.id != :last_status';
                $criteria->params[':last_status'] = $last_status->id;
            }
        }
        $criteria->order = 't.created DESC';
        $criteria = $this->addPrivacyCondition($user->id, $criteria);

        $totalItemsCount = $this->resetScope()->active()->count($criteria);
        $criteria->with = array('rubric', 'author', 'author.avatar', 'commentsCount', 'type', 'sourceCount', 'favouritesCount');

        return new CActiveDataProvider($this->resetScope()->active(), array(
            'criteria' => $criteria,
            'totalItemCount' => $totalItemsCount
        ));
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
                    'select' => array('t.id', 't.title', 't.author_id', 't.rubric_id', 't.type_id', 't.source_id'),
                    'condition' => 'rubric_id = :rubric_id AND t.id < :current_id',
                    'params' => array(':rubric_id' => $this->rubric_id, ':current_id' => $this->id),
                    'order' => 't.id DESC',
                    'limit' => 1,
                )
            );
        } else {
            $prev = self::model()->cache(300)->find(
                array(
                    'select' => array('t.id', 't.title', 't.author_id', 't.rubric_id', 't.type_id', 't.source_id'),
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
                    'limit' => 1,
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
                    'select' => array('t.id', 't.title', 't.author_id', 't.rubric_id', 't.type_id', 't.source_id'),
                    'condition' => 'rubric_id = :rubric_id AND t.id > :current_id',
                    'params' => array(':rubric_id' => $this->rubric_id, ':current_id' => $this->id),
                    'order' => 't.id',
                    'limit' => 1,
                )
            );
        } else {
            $next = self::model()->cache(300)->find(
                array(
                    'select' => array('t.id', 't.title', 't.author_id', 't.rubric_id', 't.type_id', 't.source_id'),
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
                    'limit' => 1,
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
        return ($this->getRelated('rubric')->user_id !== null && $this->type_id != self::TYPE_MORNING) || in_array($this->type_id, array(self::TYPE_STATUS, self::TYPE_REPOST));
    }

    /**
     * Может ли текущий пользователь редактировать пост
     * @return bool
     */
    public function canEdit()
    {
        if (in_array($this->author_id, array(167771, 189230, 220231)) && time() < strtotime('2014-09-04'))
            return false;

        if ($this->rubric->community_id == Community::COMMUNITY_NEWS)
            return Yii::app()->authManager->checkAccess('news', Yii::app()->user->id);

        if (Yii::app()->user->model->group == UserGroup::USER)
            return ($this->author_id == Yii::app()->user->id) && (strtotime($this->created) > strtotime('-1 month') || Yii::app()->user->model->communityContentsCount < 10);
        return (Yii::app()->user->checkAccess('editCommunityContent', array('community_id' => $this->isFromBlog ? null : $this->rubric->community->id, 'user_id' => $this->author->id)));
    }

    /**
     * Может ли текущий пользователь удалить пост
     * @return bool
     */
    public function canRemove()
    {
        if (in_array($this->author_id, array(167771, 189230, 220231)) && time() < strtotime('2014-09-04'))
            return false;

        if ($this->rubric->community_id == Community::COMMUNITY_NEWS)
            return Yii::app()->authManager->checkAccess('news', Yii::app()->user->id);

        if (Yii::app()->user->model->group == UserGroup::USER)
            return ($this->author_id == Yii::app()->user->id) && (strtotime($this->created) > strtotime('-1 month') || Yii::app()->user->model->communityContentsCount < 10);
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
            case self::TYPE_POST:
                $output = $this->post->text;
                break;
            case self::TYPE_VIDEO:
                $video = new Video($this->video->link);
                if (isset($video->image))
                    $output = CHtml::image($video->image) . $this->video->text;
                else
                    $output = $this->video->link . "<br>" . $this->video->text;
                break;
            case self::TYPE_PHOTO_POST:
                $output = CHtml::image($this->photoPost->photo->getPreviewUrl(200, 200)) . $this->photoPost->text;
                break;
            case self::TYPE_MORNING:
                $output = $this->preview;
                foreach ($this->morning->photos as $p) {
                    $output .= CHtml::tag('p', array(), CHtml::image($p->url)) . CHtml::tag('p', array(), $p->text);
                }
                break;
            case self::TYPE_STATUS:
                $output = $this->status->text;
                break;
            case self::TYPE_REPOST:
                $output = $this->preview . "<br>" . $this->source->getRssContent();
                break;
            case self::TYPE_QUESTION:
                $output = $this->question->text;
                break;
            default:
                $output = $this->content->text;
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
        if ($this->type->id == self::TYPE_REPOST)
            return $this->source->getContent();
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
     * @param null $height
     * @return bool|string
     */
    public function getContentImage($width = 580, $height = null)
    {
        if (!isset($this->content))
            return '';

        $photo = $this->content->getPhoto();
        return $photo ? $photo->getPreviewUrl($width, $height) : false;
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
        if ($this->getContent() === null) {
            echo $this->id;
            Yii::app()->end();
        }
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
        } elseif ($this->type_id == self::TYPE_MORNING) {
            $t = 'Утро с Веселым жирафом';
        } else {
            $t = htmlentities(("Клуб <span class='color-category " . $this->rubric->community->css_class . "'>" . $this->rubric->community->title . "</span>"), ENT_QUOTES, "UTF-8");
        }
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
     * Прикрепить запись блога сверху
     * @return bool
     */
    public function attachBlogPost()
    {
        $this->pinned = $this->pinned == 1 ? 0 : 1;
        return $this->update(array('pinned'));
    }

    /**
     * Настройки записи в блог
     * @return array
     */
    public function getSettingsViewModel()
    {
        return array(
            'id' => $this->id,
            'attached' => (bool) $this->pinned,
            'privacy' => (int) $this->privacy,
            'created' => strtotime($this->created),
        );
    }

    public function restore()
    {
        return self::model()->updateByPk($this->id, array('removed' => 0)) > 0;
    }


    /******************************** Repost ********************************************/
    /**
     * Возвращает пост для отображения
     * @return CommunityContent
     */
    public function getSourceContent()
    {
        return empty($this->source_id) ? $this : $this->source;
    }

    /**
     * Репостил ли эту запись пользователь
     * @param int $user_id
     * @return bool
     */
    public function userReposted($user_id)
    {
        return CommunityContent::model()->exists('author_id=:author_id AND source_id=:id', array(
            ':author_id' => $user_id,
            ':id' => $this->id
        ));
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

    /**
     * Возвращает кол-во комментариев к посту, если есть фотогалерея, то плюсует комментарии к фото
     * @return int
     */
    public function getCommentsCount()
    {
        if ($this->gallery && in_array($this->type_id, array(self::TYPE_PHOTO_POST, self::TYPE_POST))) {
            $photo_ids = $this->gallery->getPhotoIds();
            if (empty($photo_ids))
                return $this->getUnknownClassCommentsCount();

            return (int)Yii::app()->db->createCommand()
                ->select('count(id)')
                ->from('comments')
                ->where('entity=:entity AND entity_id=:entity_id OR entity="AlbumPhoto" AND entity_id IN ('
                . implode(',', $photo_ids) . ') and removed = 0', array(
                    ':entity_id' => $this->id,
                    ':entity' => $this->getIsFromBlog() ? 'BlogContent' : 'CommunityContent',
                ))
                ->queryScalar();
        }
        return $this->getUnknownClassCommentsCount();
    }

    /**
     * Если ли что-то после превью. Проверяется путем сравнения длины превью и текста
     * @return bool
     */
    public function hasMoreText()
    {
        $content = $this->getContent();
        if (isset($content->text)) {
            $preview = trim(strip_tags($this->preview));
            $text = trim(strip_tags($this->getContent()->text));
            return strlen($preview) == strlen($text) ? false : true;

        }
        return true;
    }

    public function getCacheDependency()
    {
        $contentDependency = new CDbCacheDependency('SELECT updated FROM community__contents WHERE id = :content_id;');
        $contentDependency->params = array(':content_id' => $this->id);
        $commentsDependency = new CDbCacheDependency('SELECT COUNT(*) FROM comments WHERE entity = \'CommunityContent\' AND entity_id = :content_id');
        $commentsDependency->params = array(':content_id' => $this->id);
        return new CChainedCacheDependency(array($contentDependency, $commentsDependency));
    }

    public function isAd()
    {
        if ($this->id == 101319) {
            return array(
                'text' => 'Pampers',
                'img' => '/images/banners/ava-Pampers.jpg',
                'pix' => '',
            );
        }

        if ($this->id == 204717) {
            return array(
                'text' => 'Ушастый нянь',
                'img' => '/images/banners/ava-nyan.jpg',
                'pix' => '',
            );
        }

        if (in_array($this->id, array(106365, 114024, 114026, 117229, 147851, 147856, 154876))) {
            return array(
                'text' => 'Heinz',
                'img' => '/images/banners/ava-Heinz-2.jpg',
                'pix' => '',
            );
        }

        if ($this->id == 112996) {
            return array(
                'text' => 'Clearblue',
                'img' => '/images/banners/ava-Clearblue.jpg',
                'pix' => '',
            );
        }

        $remo = <<<HTML
<!-- AdRiver code START:  ÍÓ‰ ‰Îˇ ÒˆÂÌ‡Ëˇ ; AD: 422855 "Remo-wax";   ÒˆÂÌ‡ËÈ   ID 1740991 "Happy-giraffe_2014" ; counter(zeropixel) -->
<script type="text/javascript">
var RndNum4NoCash = Math.round(Math.random() * 1000000000);
var ar_Tail='unknown'; if (document.referrer) ar_Tail = escape(document.referrer);
document.write('<img src="http://ad.adriver.ru/cgi-bin/rle.cgi?' + 'sid=1&ad=422855&bt=21&pid=1740991&bn=1740991&rnd=' + RndNum4NoCash + '&tail256=' + ar_Tail + '" border=0 width=1 height=1>')
</script>
<noscript><img src="http://ad.adriver.ru/cgi-bin/rle.cgi?sid=1&ad=422855&bt=21&pid=1740991&bn=1740991&rnd=1146898268" border=0 width=1 height=1></noscript>
<!-- AdRiver code END -->
HTML;

        if ($this->id == 199812) {
            return array(
                'text' => 'Ремо-Вакс',
                'img' => '/images/banners/ava-remowax.jpg?1',
                'pix' => $remo,
            );
        }

        if (in_array($this->id, array(33252, 4165, 34585))) {
            return array(
                'text' => '',
                'img' => '',
                'pix' => $remo,
            );
        }

        return null;
    }

    /**
     * @return mixed|string
     */
    public function getPreviewText()
    {
        return isset($this->getContent()->text) ? $this->getContent()->text : $this->title;
    }

    /**
     * @return AlbumPhoto|null
     */
    public function getPreviewPhoto()
    {
        return $this->getPhoto();
    }
}