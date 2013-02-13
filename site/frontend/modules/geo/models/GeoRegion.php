<?php

/**
 * This is the model class for table "geo_region".
 *
 * @property string $id
 * @property string $country_id
 * @property string $name
 * @property string $type
 * @property string $center_id
 * @property integer $position
 * @property integer $auto_created
 *
 * The followings are the available model relations:
 * @property GeoCity[] $geoCities
 * @property GeoDistrict[] $geoDistricts
 * @property GeoCity $center
 * @property GeoCountry $country
 */
class GeoRegion extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return GeoRegion the static model class
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
        return 'geo__region';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('country_id, name', 'required'),
            array('country_id, center_id', 'length', 'max' => 11),
            array('name', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, country_id, name', 'safe', 'on' => 'search'),
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
            'cities' => array(self::HAS_MANY, 'GeoCity', 'region_id'),
            'country' => array(self::BELONGS_TO, 'GeoCountry', 'country_id'),
            'center' => array(self::BELONGS_TO, 'GeoCity', 'center_id'),
            'usersCount' => array(self::STAT, 'UserAddress', 'region_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'country_id' => 'Country',
            'name' => 'Name',
            'center_id' => 'Центр области'
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
        $criteria->compare('country_id', $this->country_id, true);
        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 100),
        ));
    }

    public function isCity()
    {
        return $this->type == 'г';
    }
}