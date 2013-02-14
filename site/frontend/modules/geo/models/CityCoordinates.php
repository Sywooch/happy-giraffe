<?php

/**
 * This is the model class for table "geo__city_coordinates".
 *
 * The followings are the available columns in table 'geo__city_coordinates':
 * @property int $city_id
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
class CityCoordinates extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CityCoordinates the static model class
     */
    public static function model($className = __CLASS__)
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

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('city_id, location_lat, location_lng', 'required'),
            array('location_lat, location_lng, northeast_lat, northeast_lng, southwest_lat, southwest_lng', 'numerical'),
            array('city_id', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('city_id, location_lat, location_lng, northeast_lat, northeast_lng, southwest_lat, southwest_lng', 'safe', 'on' => 'search'),
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
            'city' => array(self::BELONGS_TO, 'GeoCity', 'city_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'city_id' => 'City',
            'location_lat' => 'Location Lat',
            'location_lng' => 'Location Lng',
            'northeast_lat' => 'Northeast Lat',
            'northeast_lng' => 'Northeast Lng',
            'southwest_lat' => 'Southwest Lat',
            'southwest_lng' => 'Southwest Lng',
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

        $criteria = new CDbCriteria;

        $criteria->compare('city_id', $this->city_id, true);
        $criteria->compare('location_lat', $this->location_lat);
        $criteria->compare('location_lng', $this->location_lng);
        $criteria->compare('northeast_lat', $this->northeast_lat);
        $criteria->compare('northeast_lng', $this->northeast_lng);
        $criteria->compare('southwest_lat', $this->southwest_lat);
        $criteria->compare('southwest_lng', $this->southwest_lng);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}