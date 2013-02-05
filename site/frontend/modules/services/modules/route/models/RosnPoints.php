<?php

/**
 * This is the model class for table "routes__rosn_points".
 *
 * The followings are the available columns in table 'routes__rosn_points':
 * @property string $route_id
 * @property string $name
 * @property string $region_name
 * @property integer $distance
 * @property integer $time
 * @property string $city_id
 *
 * The followings are the available model relations:
 * @property GeoCity $city
 * @property Route $route
 */
class RosnPoints extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RosnPoints the static model class
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
		return 'routes__rosn_points';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('route_id, name, region_name, distance, time', 'required'),
			array('distance, time', 'numerical', 'integerOnly'=>true),
			array('route_id, city_id', 'length', 'max'=>11),
			array('name, region_name', 'length', 'max'=>256),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('route_id, name, region_name, distance, time, city_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'city' => array(self::BELONGS_TO, 'GeoCity', 'city_id'),
			'route' => array(self::BELONGS_TO, 'Route', 'route_id'),
		);
	}
}