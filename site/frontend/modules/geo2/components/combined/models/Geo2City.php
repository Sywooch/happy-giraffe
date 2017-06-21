<?php

namespace site\frontend\modules\geo2\components\combined\models;

/**
 * This is the model class for table "geo2__city".
 *
 * The followings are the available columns in table 'geo2__city':
 * @property string $id
 * @property string $countryId
 * @property string $regionId
 * @property string $title
 * @property string $vkId
 * @property string $fiasId
 */
class Geo2City extends \CActiveRecord implements \IHToJSON
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'geo2__city';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{

	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return [
			'country' => array(self::BELONGS_TO, 'site\frontend\modules\geo2\components\combined\models\Geo2Country', 'countryId'),
			'region' => array(self::BELONGS_TO, 'site\frontend\modules\geo2\components\combined\models\Geo2Region', 'regionId'),
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'countryId' => 'Country',
			'regionId' => 'Region',
			'title' => 'Title',
			'vkId' => 'Vk',
			'fiasId' => 'Fias',
		];
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Geo2City the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function toJSON()
	{
		return [
			'id' => (int) $this->id,
			'country' => $this->country,
			'region' => $this->region,
			'title' => $this->title,
			'area' => $this->area,
		];
	}
	
	public function search($term)
	{
		if ($term) {
			$this->getDbCriteria()->addSearchCondition('title', $term . '%', false);
		}
		return $this;
	}
	
	public function country($countryId)
	{
		$this->getDbCriteria()->compare('countryId', $countryId);
		return $this;
	}
	
	public function title($title)
	{
		$this->getDbCriteria()->compare($this->tableAlias . '.title', $title);
		return $this;
	}

	public function noRegion()
	{
		$this->getDbCriteria()->addCondition('regionId IS NULL');
		return $this;
	}
}
