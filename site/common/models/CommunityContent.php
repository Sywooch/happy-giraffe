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
 *
 * @method CommunityContent full()
 * @method CommunityContent findByPk()
 */
class CommunityContent extends HActiveRecord
{
    const USERS_COMMUNITY = 999999;

	/**
	 * Returns the static model of the specified AR class.
	 * @return CommunityContent the static model class
	 */
	public static function model($className=__CLASS__)
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
			array('title, author_id, type_id', 'required'),
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
			array('id, by_happy_giraffe, title, meta_title, meta_description, meta_keywords, created, author_id, rubric_id, type_id', 'safe', 'on'=>'search'),
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
            'travel' => array(self::HAS_ONE, 'CommunityTravel', 'content_id', 'on' => "slug = 'travel'"),
            'video' => array(self::HAS_ONE, 'CommunityVideo', 'content_id', 'on' => "slug = 'video'"),
            'post' => array(self::HAS_ONE, 'CommunityPost', 'content_id', 'on' => "slug = 'post'"),
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
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
            ),
            'purified' => array(
                'class' => 'site.common.behaviors.PurifiedBehavior',
                'attributes' => array( 'preview'),
            ),
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('author_id',$this->author_id,true);
		$criteria->compare('rubric_id',$this->rubric_id,true);
		$criteria->compare('type_id',$this->type_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination' => array('pageSize' => 30),
		));
	}

	public function community($community_id)
	{
		$this->getDbCriteria()->mergeWith(array(
			'with' => array(
				'rubric' => array(
					'select' => FALSE,
					'with' => array(
						'community' => array(
							'select' => FALSE,
							'condition' => 'community_id=:community_id',
							'params' => array(':community_id' => $community_id),
						)
					),
				),
				'post',
				'video',
				'commentsCount',
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
			'order' => 't.id DESC',
		));
		return $this;
	}

	public function type($type_id)
	{
		if ($type_id !== null)
		{
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
		if ($rubric_id !== null)
		{
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
            UserScores::removeScores($this->author_id, ScoreActions::ACTION_FIRST_BLOG_RECORD, 1, $this);
        }else
            UserScores::removeScores($this->author_id, ScoreActions::ACTION_RECORD, 1, $this);
        //сообщаем пользователю
        UserNotification::model()->create(UserNotification::DELETED, array('entity' => $this));
        //закрываем сигнал
        UserSignal::closeRemoved($this);

        return false;
    }

    public function purify($t)
    {
        $p = new CHtmlPurifier();
        $p->options = array(
            'URI.AllowedSchemes'=>array(
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

    public function afterSave()
    {
        if ($this->isNewRecord && $this->type_id != 4) {
            Yii::app()->cache->set('activityLastUpdated', time());
        }

        if ($this->type_id == 4 || $this->by_happy_giraffe) {
            $pingUserId = 1;
        } else {
            $pingUserId = $this->author_id;
        }
        $pingName = 'Блог пользователя ' . $this->author->fullName;
        $pingUrl = Yii::app()->createAbsoluteUrl('rss/user', array('user_id' => $pingUserId));

        $xmlDoc = new DOMDocument;
        $methodCall = $xmlDoc->createElement('methodCall');
        $xmlDoc->appendChild($methodCall);
        $methodCall->appendChild($xmlDoc->createElement('methodName', 'weblogUpdates.ping'));
        $params = $xmlDoc->createElement('params');
        $methodCall->appendChild($params);
        $param = $xmlDoc->createElement('param');
        $param->appendChild($xmlDoc->createElement('value', $pingName));
        $params->appendChild($param);
        $param = $xmlDoc->createElement('param');
        $param->appendChild($xmlDoc->createElement('value', $pingUrl));
        $params->appendChild($param);
        $xml = $xmlDoc->saveXML();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://ping.blogs.yandex.ru/RPC2');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);

        Yii::log($output, 'error');

        if (get_class(Yii::app()) == 'CConsoleApplication')
            return parent::afterSave();
        if ($this->contentAuthor->isNewComer() && $this->isNewRecord) {
            $signal = new UserSignal();
            $signal->user_id = (int)$this->author_id;
            $signal->item_id = (int)$this->id;
            $signal->item_name = 'CommunityContent';

            if ($this->isFromBlog)
                $signal->signal_type = UserSignal::TYPE_NEW_BLOG_POST;
            else{
                if ($this->type->slug == 'video')
                    $signal->signal_type = UserSignal::TYPE_NEW_USER_VIDEO;
                else
                    $signal->signal_type = UserSignal::TYPE_NEW_USER_POST;
            }

            if (!$signal->save()) {
                Yii::log('NewComers signal not saved', 'warning', 'application');
            }
        }
        if ($this->isNewRecord && $this->rubric_id !== null){
            if ($this->isFromBlog && count($this->contentAuthor->blogPosts) == 1) {
                UserScores::addScores($this->author_id, ScoreActions::ACTION_FIRST_BLOG_RECORD, 1, $this);
            }else
                UserScores::addScores($this->author_id, ScoreActions::ACTION_RECORD, 1, $this);
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
                if ($this->isFromBlog) {
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
                            'community' => array(
                                'select' => 'id',
                            )
                        ),
                    ),
                    'type' => array(
                        'select' => 'slug',
                    ),
                    'post',
                    'video',
                    'travel',
                    'commentsCount',
                    'contentAuthor' => array(
                        'select' => 'id, first_name, last_name, avatar_id, online, blocked, deleted',
                    ),
                ),
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

        if ($rubric_id !== null)
        {
            $criteria->compare('rubric_id', $rubric_id);
        }

        if ($content_type_slug !== null)
        {
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
            'condition' => 'rubric.user_id IS NOT NULL AND t.author_id = :user_id',
            'params' => array(':user_id' => $user_id),
        ));

        if ($rubric_id !== null)
        {
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
        if (! $this->isFromBlog) {
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
        if (! $this->isFromBlog) {
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
        return ($this->rubric_id !== null) && ($this->getRelated('rubric')->user_id !== null);
    }

    public function defaultScope()
    {
        return array(
            'condition' => 'removed = 0',
        );
    }

    public function getShort()
    {
        switch ($this->type_id) {
            case 1:
                if (preg_match('/src="([^"]+)"/', $this->post->text, $matches)) {
                    return '<img src="' . $matches[1] . '" alt="' . $this->title . '" />';
                } else {
                    return Str::truncate(strip_tags($this->post->text));
                }
                break;
            case 2:
                $video = new Video($this->video->link);
                return '<img src="' . $video->preview . '" alt="' . $video->title . '" />';
                break;
            default:
                return '';
        }
    }

    public function canEdit()
    {
        if (Yii::app()->user->model->role == 'user'){
            if ($this->author_id == Yii::app()->user->id)
                return true;
            return false;
        }
        return (Yii::app()->user->checkAccess('editCommunityContent', array('community_id' => $this->isFromBlog ? null : $this->rubric->community->id, 'user_id' => $this->contentAuthor->id)));
    }

    public function canRemove()
    {
        if (Yii::app()->user->model->role == 'user'){
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
}