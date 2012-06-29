<?php

/**
 * This is the model class for table "community__travels".
 *
 * The followings are the available columns in table 'community__travels':
 * @property string $id
 * @property string $text
 * @property string $content_id
 *
 * The followings are the available model relations:
 * @property ClubCommunityContent $content
 * @property ClubCommunityTravelWaypoint[] $clubCommunityTravelWaypoints
 */
class CommunityTravel extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CommunityTravel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function behaviors()
	{
		return array(
			'cut' => array(
                'class' => 'site.common.behaviors.CutBehavior',
				'attributes' => array('text'),
				'edit_routes' => array('community/editTravel'),
			),
		);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'community__travels';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('text', 'required'),
			array('content_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, text, content_id', 'safe', 'on'=>'search'),
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
			'content' => array(self::BELONGS_TO, 'CommunityContent', 'content_id'),
			'waypoints' => array(self::HAS_MANY, 'CommunityTravelWaypoint', 'travel_id'),
			'images' => array(self::HAS_MANY, 'CommunityTravelImage', 'travel_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'text' => 'Текст',
			'content_id' => 'Content',
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
		$criteria->compare('text',$this->text,true);
		$criteria->compare('content_id',$this->content_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}