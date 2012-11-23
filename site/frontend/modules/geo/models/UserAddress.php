<?php

/**
 * This is the model class for table "geo__user_address".
 *
 * The followings are the available columns in table 'geo__user_address':
 * @property string $user_id
 * @property string $country_id
 * @property string $region_id
 * @property string $city_id
 * @property string $street_id
 * @property string $house
 * @property string $room
 * @property string $manual
 *
 * The followings are the available model relations:
 * @property GeoCity $city
 * @property GeoCountry $country
 * @property GeoRegion $region
 * @property User $user
 */
class UserAddress extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserAddress the static model class
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
        return 'geo__user_address';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id', 'required'),
            array('user_id, house, room', 'length', 'max' => 10),
            array('country_id, region_id, city_id, street_id', 'length', 'max' => 11),
            array('manual', 'length', 'max' => 256),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('user_id, country_id, region_id, city_id, street_id, house, room, manual', 'safe', 'on' => 'search'),
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
            'country' => array(self::BELONGS_TO, 'GeoCountry', 'country_id'),
            'region' => array(self::BELONGS_TO, 'GeoRegion', 'region_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'user_id' => 'User',
            'country_id' => 'Country',
            'region_id' => 'Region',
            'city_id' => 'City',
            'street_id' => 'Street',
            'house' => 'House',
            'room' => 'Room',
            'manual' => 'Manual',
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

        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('country_id', $this->country_id, true);
        $criteria->compare('region_id', $this->region_id, true);
        $criteria->compare('city_id', $this->city_id, true);
        $criteria->compare('street_id', $this->street_id, true);
        $criteria->compare('house', $this->house, true);
        $criteria->compare('room', $this->room, true);
        $criteria->compare('manual', $this->manual, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function beforeSave()
    {
        if (!empty($this->country_id))
            UserScores::checkProfileScores($this->user_id, ScoreAction::ACTION_PROFILE_LOCATION);

        User::model()->UpdateUser($this->user_id);

        return parent::beforeSave();
    }

    public function getFlag($big = false, $element = 'div')
    {
        if (!empty($this->country_id)) {
            if ($big){
                $cache_id = 'geo_flag_big_'.$this->country_id.'_'.$element;
                $value=Yii::app()->cache->get($cache_id);
                if($value===false)
                {
                    $value = '<' . $element . ' class="flag-big flag-big-' . strtolower($this->country->iso_code)
                        . '" title="' . $this->country->name . '"></' . $element . '>';
                    Yii::app()->cache->set($cache_id,$value);
                }
                return $value;
            }
            else{
                $cache_id = 'geo_flag_'.$this->country_id.'_'.$element;
                $value=Yii::app()->cache->get($cache_id);
                if($value===false)
                {
                    $value = '<' . $element . ' class="flag flag-' . strtolower($this->country->iso_code)
                        . '" title="' . $this->country->name . '"></' . $element . '>';
                    Yii::app()->cache->set($cache_id,$value);
                }
                return $value;
            }
        } else
            return '';
    }

    public function getLocationString()
    {
        if (empty($this->country_id))
            return '';

        $cache_id = 'geo_loc2_'.$this->country_id.'_'.$this->city_id.'_'.$this->region_id;
        $value=Yii::app()->cache->get($cache_id);
        if($value===false)
        {
            $value = $this->getCountryTitle();
            if (!empty($this->region_id)) {
                $value .= ', ' . $this->region->name;
                if (!empty($this->city_id)) {
                    $value .= ', ' . $this->city->type . ' ' . $this->city->name;
                }
            }
            Yii::app()->cache->set($cache_id,$value);
        }


        return $value;
    }

    public function getLocationWithoutCountry()
    {
        $cache_id = 'geo_loc_'.$this->country_id.'_'.$this->city_id.'_'.$this->region_id;
        $value=Yii::app()->cache->get($cache_id);
        if($value===false)
        {
            if (!empty($this->city_id)) {
                $city_string = (empty($this->city->type)) ? $this->city->name : $this->city->type . ' ' . $this->city->name;
                if (empty($this->region_id)) {
                    $value = $city_string;
                } elseif (empty($this->city->district_id)) {
                    $value = str_replace('область', 'обл', $this->region->name) . '<br> ' . $city_string;
                } else {
                    $value = str_replace('область', 'обл', $this->region->name) . '<br> ' . $this->city->district->name . ' р-н<br>'
                        . $city_string;
                }
            } elseif (!empty($this->region_id)) {
                $value = $this->region->name;
            }

            Yii::app()->cache->set($cache_id,$value);
        }

        return $value;
    }

    public function hasCity()
    {
        return !empty($this->city_id) || ($this->region !== null && $this->region->isCity());
    }

    public function getCityName()
    {
        if (!empty($this->city_id))
            return $this->getCityTitle();
        return $this->getRegionTitle();
    }

    public function getCountryTitle()
    {
        if (empty($this->country_id))
            return '';

        $cache_id = 'geo_county_' . $this->country_id;
        $value = Yii::app()->cache->get($cache_id);
        if ($value === false) {
            $value = $this->country->name;
            Yii::app()->cache->set($cache_id, $value);
        }

        return $value;
    }

    public function getCityTitle()
    {
        if (empty($this->city_id))
            return '';

        $cache_id = 'geo_city_' . $this->city_id;
        $value = Yii::app()->cache->get($cache_id);
        if ($value === false) {
            $value = $this->city->name;
            Yii::app()->cache->set($cache_id, $value);
        }

        return $value;
    }

    public function getRegionTitle()
    {
        if (empty($this->region_id))
            return '';

        $cache_id = 'geo_region_' . $this->region_id;
        $value = Yii::app()->cache->get($cache_id);
        if ($value === false) {
            if ($this->region->isCity())
                $value = $this->region->name;
            else
                $value ='';

            Yii::app()->cache->set($cache_id, $value);
        }

        return $value;
    }
}