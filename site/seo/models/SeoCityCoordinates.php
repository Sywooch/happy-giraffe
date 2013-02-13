<?php

/**
 * This is the model class for table "geo__city_coordinates".
 *
 * The followings are the available columns in table 'geo__city_coordinates':
 * @property string $city_id
 * @property double $location_lat
 * @property double $location_lng
 * @property double $northeast_lat
 * @property double $northeast_lng
 * @property double $southwest_lat
 * @property double $southwest_lng
 *
 * The followings are the available model relations:
 * @property GeoCity $city
 */
class SeoCityCoordinates extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CityCoordinates the static model class
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
		return 'geo__city_coordinates';
	}

    public function getDbConnection()
    {
        return Yii::app()->db_seo;
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('city_id', 'required'),
			array('location_lat, location_lng, northeast_lat, northeast_lng, southwest_lat, southwest_lng', 'numerical'),
			array('city_id', 'length', 'max'=>10),
		);
	}
}