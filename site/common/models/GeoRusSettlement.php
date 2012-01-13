<?php

/**
 * This is the model class for table "geo_rus_settlement".
 *
 * The followings are the available columns in table 'geo_rus_settlement':
 * @property string $id
 * @property string $name
 * @property string $district_id
 * @property string $region_id
 */
class GeoRusSettlement extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return GeoRusSettlement the static model class
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
		return '{{geo_rus_settlement}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array('name, region_id', 'required'),
			array('name', 'length', 'max'=>255),
			array('district_id, region_id', 'length', 'max'=>11),
			array('id, name, district_id, region_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
			'streets' => array(self::HAS_MANY, 'GeoRusStreet', 'settlement_id'),
			'region' => array(self::BELONGS_TO, 'GeoRusRegion', 'region_id'),
			'district' => array(self::BELONGS_TO, 'GeoRusDistrict', 'district_id'),
			'type' => array(self::BELONGS_TO, 'GeoRusSettlementType', 'type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'district_id' => 'District',
			'region_id' => 'Region',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		$criteria = new CDbCriteria;
		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('district_id',$this->district_id,true);
		$criteria->compare('region_id',$this->region_id,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Retrivies cities whose name like $title.
	 * Is $regionId is not empty, retrivies cities whose name like $title
	 * and region_id equal $regionId
	 * @param string $title
	 * @param int $regionId 
	 * @return array
	 */
	public function getCitiesByTitle($title, $regionId = '') { 
		$where = array('and');
		$title = strtr($title, array('%' => '\%', '_' => '\_'));
		$where[] = array('like', 'name', "%$title%");
		if ($regionId) {
			$where[] = array('in', 'region_id', array($regionId));
		}
		$command = Y::command();
		$command->select('id, name AS value, name AS label');
		$command->from(self::model()->tableName());
		$command->where($where);
		$command->order('name');
		$command->limit(30);
		return $command->queryAll();
	}
}