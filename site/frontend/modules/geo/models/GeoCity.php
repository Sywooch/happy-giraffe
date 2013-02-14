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
 * @property string $name_from
 * @property string $name_between
 * @property string $type
 * @property string $auto_created
 * @property string $declension_checked
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
            array('name, name_between, name_from', 'length', 'max' => 255),
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
            'name' => 'Название',
            'name_from' => 'от ...',
            'name_between' => 'между ...',
            'declension_checked' => 'Склонения проверены',
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
            'pagination' => array('pageSize' => 100),
        ));
    }

    public function declensionSearch()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (empty($this->id))
            $criteria->condition = 'name_from IS NOT NULL AND declension_checked=0';
        else
            $criteria->compare('id', $this->id, true);
        $criteria->compare('region_id', $this->region_id, true);
        $criteria->compare('country_id', $this->country_id, true);
        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 100),
        ));
    }

    public function declCheckedLink()
    {
        return '<input type="hidden" value="' . $this->id . '"><a class="decl_checked" href="javascript:;">проверено</a>';
    }

    public function beforeSave()
    {
        //склонение
        if ($this->isNewRecord) {
            $c = new CityDeclension();
            list($n1, $n2) = $c->getDeclensions($this->name);
            $this->name_from = $n1;
            $this->name_between = $n2;
        }

        return parent::beforeSave();
    }

    public function getFullName()
    {
        $text = $this->name;
        if (!empty($this->district_id)) {
            //если есть такой же город в этом регионе
            $criteria = new CDbCriteria;
            $criteria->compare('region_id', $this->region_id);
            $count = GeoCity::model()->count($criteria);

            if ($count > 1)
                $text .= ', ' . $this->district->name . ' район';
        }
        if (!empty($this->region_id) && $this->region->name !== $this->name)
            $text .= ', ' . $this->region->name;

        $text .= ', ' . $this->country->name;

        return trim($text);
    }

    /**
     * @param $lat float
     * @param $lng float
     * @return GeoCity
     */
    public static function getCityByCoordinates($lat, $lng)
    {
        $coordinates = self::getCityByCoordinatesFromExisting($lat, $lng);
        if ($coordinates === null) {
            //если не нашли по координатам - узнаем у google maps какой город находиться в этом месте
            $city = self::getCityFromGoogleMaps($lat, $lng);
            return $city;
        }

        return $coordinates->city;
    }

    public static function getCityByCoordinatesFromExisting($lat, $lng)
    {
        $lat = (string)round(trim($lat), 5);
        $lng = (string)round(trim($lng), 5);
        $criteria = new CDbCriteria;
        $criteria->condition = 'location_lat = ' . $lat . ' AND location_lng = ' . $lng;
        return CityCoordinates::model()->find($criteria);
    }

    public static function getCityFromGoogleMaps($lat, $lng)
    {
        $parser = new GoogleMapsGeoCode;
        $city = $parser->getCityByCoordinates($lat, $lng);
        if ($city !== null) {
            $coordinates = new CityCoordinates();
            $coordinates->city_id = $city->id;
            $coordinates->location_lat = $lat;
            $coordinates->location_lng = $lng;
            $coordinates->save();
        }

        return $city;
    }
}