<?php

/**
 * This is the model class for table "community__travel_waypoints".
 *
 * The followings are the available columns in table 'community__travel_waypoints':
 * @property string $id
 * @property string $city_id
 * @property string $country_id
 * @property string $travel_id
 *
 * The followings are the available model relations:
 * @property ClubCommunityTravel $travel
 * @property GeoCity $city
 * @property GeoCountry $country
 */
class CommunityTravelWaypoint extends CActiveRecord
{
	public $country_name;
	public $city_name;

	public function afterFind()
	{
		$country = GeoCountry::model()->findByAttributes(array('id' => $this->country_id));
		$this->country_name = $country->name;
		$city = GeoCity::model()->findByAttributes(array('id' => $this->city_id));
		$this->city_name = $city->name;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @return CommunityTravelWaypoint the static model class
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
		return 'community__travel_waypoints';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('city_id, country_id', 'required'),
			array('travel_id', 'safe'),
			array('city_id', 'exist', 'attributeName' => 'id', 'className' => 'GeoCity'),
			array('country_id', 'exist', 'attributeName' => 'id', 'className' => 'GeoCountry'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, city_id, country_id, travel_id', 'safe', 'on'=>'search'),
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
			'city' => array(self::BELONGS_TO, 'GeoCity', 'city_id'),
			'country' => array(self::BELONGS_TO, 'GeoCountry', 'country_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'city_id' => 'City',
			'country_id' => 'Country',
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
		$criteria->compare('city_id',$this->city_id,true);
		$criteria->compare('country_id',$this->country_id,true);
		$criteria->compare('travel_id',$this->travel_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}