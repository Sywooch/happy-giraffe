<?php

/**
 * This is the model class for table "geo_city".
 *
 * The followings are the available columns in table 'geo_city':
 * @property string $id
 * @property string $district_id
 * @property string $region_id
 * @property string $country_id
 * @property string $name
 * @property string $type
 *
 * The followings are the available model relations:
 * @property GeoCountry $country
 * @property GeoDistrict $district
 * @property GeoRegion $region
 * @property GeoZip[] $zips
 */
class GeoCity extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return GeoCity the static model class
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
        return 'geo__city';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('region_id, country_id, name', 'required'),
            array('region_id, country_id, district_id', 'length', 'max' => 11),
            array('name', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, region_id, country_id, name', 'safe', 'on' => 'search'),
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
            'country' => array(self::BELONGS_TO, 'GeoCountry', 'country_id'),
            'region' => array(self::BELONGS_TO, 'GeoRegion', 'region_id'),
            'district' => array(self::BELONGS_TO, 'GeoDistrict', 'district_id'),
            'zips' => array(self::HAS_MANY, 'GeoZip', 'city_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'region_id' => 'Region',
            'country_id' => 'Country',
            'name' => 'Name',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('region_id', $this->region_id, true);
        $criteria->compare('country_id', $this->country_id, true);
        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getFullName()
    {
        $text = $this->name;
        if (!empty($this->district_id)) {
            //если есть такой же город в этом регионе
//            $criteria = new CDbCriteria;
//            $criteria->compare('region_id', $this->region_id);
//            $count = GeoCity::model()->count($criteria);
//
//            if ($count > 1)

            $text .= ', ' . $this->district->name . ' район';
        }
        if (!empty($this->region_id) && $this->region->name !== $this->name)
            $text .= ', ' . $this->region->name;

        $text .= ', ' . $this->country->name;

        return $text;
    }
}