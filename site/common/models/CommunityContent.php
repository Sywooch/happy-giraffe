<?php

/**
 * This is the model class for table "{{community_content}}".
 *
 * The followings are the available columns in table '{{community_content}}':
 * @property string $id
 * @property string $name
 * @property string $created
 * @property string $author_id
 * @property string $rubric_id
 * @property string $type_id
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property integer $by_happy_giraffe
 *
 * The followings are the available model relations:
 *
 * @property CommunityComment[] $comments
 * @property User $contentAuthor
 * @property CommunityRubric $rubric
 * @property CommunityContentType $type
 * @property CommunityPost $post
 * @property CommunityVideo $video
 */
class CommunityContent extends CActiveRecord
{
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
		return '{{club_community_content}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, author_id, rubric_id, type_id', 'required'),
			array('name, meta_title, meta_description, meta_keywords', 'length', 'max' => 255),
			array('author_id, rubric_id, type_id', 'length', 'max' => 11),
			array('author_id, rubric_id, type_id', 'numerical', 'integerOnly' => true),
			array('rubric_id', 'exist', 'attributeName' => 'id', 'className' => 'CommunityRubric'),
			array('author_id', 'exist', 'attributeName' => 'id', 'className' => 'User'),
			array('by_happy_giraffe', 'boolean'),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, by_happy_giraffe, name, meta_title, meta_description, meta_keywords, created, author_id, rubric_id, type_id', 'safe', 'on'=>'search'),
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
			'commentsCount' => array(self::STAT, 'Comment', 'object_id', 'condition' => 'model=:modelName', 'params' => array(':modelName' => 'CommunityContent')),
			'travel' => array(self::HAS_ONE, 'CommunityTravel', 'content_id'),
			'video' => array(self::HAS_ONE, 'CommunityVideo', 'content_id'),
			'post' => array(self::HAS_ONE, 'CommunityPost', 'content_id'),
			'contentAuthor' => array(self::BELONGS_TO, 'User', 'author_id'),
            'author' => array(self::BELONGS_TO, 'User', 'author_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'created' => 'Created',
			'author_id' => 'Author',
			'rubric_id' => 'Rubric',
			'type_id' => 'Type',
		);
	}

    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('author_id',$this->author_id,true);
		$criteria->compare('rubric_id',$this->rubric_id,true);
		$criteria->compare('type_id',$this->type_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
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
	
	public function scopes()
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
		);
	}

    public function beforeDelete()
    {
        $criteria = new EMongoCriteria();
        $criteria->item_name = 'CommunityContent';
        $criteria->item_id = $this->id;
        UserSignal::model()->deleteAll($criteria);

        $moderators = AuthAssignment::model()->findAll('itemname="moderator"');
        foreach ($moderators as $moderator) {
//            Yii::app()->comet->send(MessageCache::GetUserCache($moderator->userid), array(
//                'type' => self::SIGNAL_UPDATE
//            ));
        }

        return true;
    }

    public function afterSave()
    {
        if ($this->contentAuthor->isNewComer() && $this->isNewRecord){
            $signal = new UserSignal();
            $signal->user_id = $this->author_id;
            $signal->item_id = $this->id;
            $signal->item_name = 'CommunityContent';
            if ($this->type->slug == 'video')
                $signal->signal_type = UserSignal::TYPE_NEW_USER_VIDEO;
            elseif ($this->type->slug == 'travel')
                $signal->signal_type = UserSignal::TYPE_NEW_USER_TRAVEL;
            else
                $signal->signal_type = UserSignal::TYPE_NEW_USER_POST;

            if (!$signal->save()){
                Yii::log('NewComers signal not saved', 'warning', 'application');
            }
        }
        return parent::afterSave();
    }

    public static function getLink($id)
    {
        $model = self::model()->with(array(
            'type'=>array(
                'select'=>'slug'
            ),'rubric'=>array(
                'select'=>'community_id'
            )
        ))->findByPk($id);
        return Yii::app()->createUrl('community/view', array('community_id' => $model->rubric->community_id,
            'content_type_slug' => $model->type->slug, 'content_id' => $model->id));
    }
}