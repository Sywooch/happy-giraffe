<?php

namespace site\frontend\modules\geo2\models;
use site\frontend\modules\geo2\components\combined\models\Geo2City;
use site\frontend\modules\geo2\components\combined\models\Geo2Country;
use site\frontend\modules\geo2\components\combined\models\Geo2Region;

/**
 * This is the model class for table "geo2__user_location".
 *
 * The followings are the available columns in table 'geo2__user_location':
 * @property string $id
 * @property string $countryId
 * @property string $regionId
 * @property string $cityId
 *
 * The followings are the available model relations:
 * @property Geo2City $city
 * @property Geo2Country $country
 * @property Geo2Region $region
 */
class UserLocation extends \CActiveRecord implements \IHToJSON
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'geo2__user_location';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			
		];
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'city' => array(self::BELONGS_TO, Geo2City::class, 'cityId'),
			'country' => array(self::BELONGS_TO, Geo2Country::class, 'countryId'),
			'region' => array(self::BELONGS_TO, Geo2Region::class, 'regionId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'countryId' => 'Country',
			'regionId' => 'Region',
			'cityId' => 'City',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserLocation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function toJSON()
	{
		return [
			'id' => (int) $this->id,
			'city' => $this->city ? [
				'id' => (int) $this->city->id,
				'title' => $this->city->title,
				'area' => $this->city->area,
			] : null,
			'region' => $this->region,
			'country' => $this->country,
		];
	}

	protected function beforeSave()
	{
		if ($this->cityId) {
			$this->regionId = $this->city->regionId;
			$this->countryId = $this->city->countryId;
		} elseif ($this->regionId) {
			$this->countryId = $this->region->countryId;
		}

		return parent::beforeSave();
	}
}
