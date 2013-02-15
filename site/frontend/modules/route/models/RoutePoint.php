<?php

/**
 * This is the model class for table "routes__rosn_points".
 *
 * The followings are the available columns in table 'routes__rosn_points':
 * @property integer $id
 * @property string $route_id
 * @property string $name
 * @property string $region_id
 * @property integer $distance
 * @property integer $time
 * @property string $city_id
 *
 * The followings are the available model relations:
 * @property Route $route
 * @property GeoCity $city
 * @property GeoRegion $region
 */
class RoutePoint extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RoutePoint the static model class
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
		return 'routes__points';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('route_id, name, region_id, distance, time', 'required'),
			array('distance, time', 'numerical', 'integerOnly'=>true),
			array('route_id, city_id', 'length', 'max'=>11),
			array('name', 'length', 'max'=>256),
			array('region_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, route_id, name, region_id, distance, time, city_id', 'safe', 'on'=>'search'),
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
			'route' => array(self::BELONGS_TO, 'Route', 'route_id'),
			'city' => array(self::BELONGS_TO, 'GeoCity', 'city_id'),
			'region' => array(self::BELONGS_TO, 'GeoRegion', 'region_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'route_id' => 'Route',
			'name' => 'Name',
			'region_id' => 'Region',
			'distance' => 'Distance',
			'time' => 'Time',
			'city_id' => 'City',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('route_id',$this->route_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('region_id',$this->region_id,true);
		$criteria->compare('distance',$this->distance);
		$criteria->compare('time',$this->time);
		$criteria->compare('city_id',$this->city_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}