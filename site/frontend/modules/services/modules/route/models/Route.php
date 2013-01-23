<?php

/**
 * This is the model class for table "routes__routes".
 *
 * The followings are the available columns in table 'routes__routes':
 * @property string $id
 * @property string $city_from_id
 * @property string $city_to_id
 * @property integer $wordstat
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property RouteLink[] $outLinks
 * @property RouteLink[] $inLinks
 * @property GeoCity $cityFrom
 * @property GeoCity $cityTo
 */
class Route extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Route the static model class
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
		return 'routes__routes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('city_from_id, city_to_id', 'required'),
			array('wordstat, active', 'numerical', 'integerOnly'=>true),
			array('city_from_id, city_to_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, city_from_id, city_to_id, wordstat, active', 'safe', 'on'=>'search'),
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
			'inLinks' => array(self::HAS_MANY, 'RouteLink', 'route_to_id'),
			'outLinks' => array(self::HAS_MANY, 'RouteLink', 'route_from_id', 'order'=>'created asc'),
			'outLinksCount' => array(self::STAT, 'RouteLink', 'route_from_id'),
			'cityFrom' => array(self::BELONGS_TO, 'GeoCity', 'city_from_id'),
			'cityTo' => array(self::BELONGS_TO, 'GeoCity', 'city_to_id'),
		);
	}
}