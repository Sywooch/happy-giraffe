<?php

/**
 * This is the model class for table "{{community_content}}".
 *
 * The followings are the available columns in table '{{community_content}}':
 * @property string $id
 * @property string $name
 * @property string $created
 * @property string $views
 * @property string $rating
 * @property string $author_id
 * @property string $rubric_id
 * @property string $type_id
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
			array('views, rating, author_id, rubric_id, type_id', 'length', 'max' => 11),
			array('views, rating, author_id, rubric_id, type_id', 'numerical', 'integerOnly' => true), 
			array('rubric_id', 'exist', 'attributeName' => 'id', 'className' => 'CommunityRubric'),
			array('by_happy_giraffe', 'boolean'),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, by_happy_giraffe, name, meta_title, meta_description, meta_keywords, created, views, rating, author_id, rubric_id, type_id', 'safe', 'on'=>'search'),
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
			'comments' => array(self::HAS_MANY, 'CommunityComment', 'content_id'),
			'commentsCount' => array(self::STAT, 'Comment', 'object_id', 'condition' => 'model=:modelName', 'params' => array(':modelName' => 'CommunityContent')),
			'video' => array(self::HAS_ONE, 'CommunityVideo', 'content_id', 'on' => 'type_id = 2'),
			'post' => array(self::HAS_ONE, 'CommunityPost', 'content_id', 'on' => 'type_id = 1'),
			'contentAuthor' => array(self::BELONGS_TO, 'User', 'author_id'),
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
			'views' => 'Views',
			'rating' => 'Rating',
			'author_id' => 'Author',
			'rubric_id' => 'Rubric',
			'type_id' => 'Type',
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
		$criteria->compare('views',$this->views,true);
		$criteria->compare('rating',$this->rating,true);
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
			),
			'order' => 'created DESC',
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
					'comments' => array(
						'with' => array(
							'commentAuthor',
						),
						'order' => 'comments.created DESC',
					),
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
				),
			),
		);
	}
	
}