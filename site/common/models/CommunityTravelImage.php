<?php

/**
 * This is the model class for table "community__travel_images".
 *
 * The followings are the available columns in table 'community__travel_images':
 * @property string $id
 * @property string $image
 * @property string $travel_id
 */
class CommunityTravelImage extends HActiveRecord
{
	public function getUrl($size)
	{
		return '/upload/travels/' . $size . '/' . $this->image;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @return CommunityTravelImage the static model class
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
		return 'community__travel_images';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('image', 'required'),
			array('image', 'length', 'max'=>255),
			array('travel_id', 'safe',),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, image, travel_id', 'safe', 'on'=>'search'),
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
			'travel' => array(self::BELONGS_TO, 'CommunityTravel', 'travel_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'image' => 'Image',
			'travel_id' => 'Travel',
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
		$criteria->compare('image',$this->image,true);
		$criteria->compare('travel_id',$this->travel_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}