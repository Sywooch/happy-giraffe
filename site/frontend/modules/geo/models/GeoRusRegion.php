<?php

/**
 * This is the model class for table "geo_rus_region".
 *
 * The followings are the available columns in table 'geo_rus_region':
 * @property string $id
 * @property string $name
 * @property string $region_center_id
 * @property string $area_center_id
 * @property integer $settlement_id
 * @property integer $pos
 *
 * The followings are the available model relations:
 * @property GeoRusSettlement[] $settlement
 */
class GeoRusRegion extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return GeoRusRegion the static model class
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
		return 'geo__rus_region';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, id', 'required'),
			array('settlement_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, settlement_id', 'safe'),
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
		    'settlement' => array(self::BELONGS_TO, 'GeoRusSettlement', 'settlement_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'id' => 'ID',
            'name' => 'Name',
            'region_center_id' => 'Region Center',
            'area_center_id' => 'Area Center',
            'settlement_id' => 'Settlement',
            'pos' => 'Order position',
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

		$criteria=new CDbCriteria;

        $criteria->compare('id',$this->id,true);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('region_center_id',$this->region_center_id,true);
        $criteria->compare('area_center_id',$this->area_center_id,true);
        $criteria->compare('settlement_id',$this->settlement_id);
        $criteria->compare('pos',$this->pos);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	public function searchRegions() {
	    $criteria = new CDbCriteria;

	    $criteria->compare('id', $this->id);

	    return new CActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
		    ));
	}

	public function getRegions() {
	    $vid = md5(__CLASS__ . __FUNCTION__);
	    $value = Yii::app()->cache->get($vid);
	    if (!$value) {
			$models = $this->findAll();
			$carr = array();
			foreach ($models as $model)
				$carr[$model->id] = $model->name;
			asort($carr, SORT_STRING);
			$value = $carr;
			Yii::app()->cache->set($vid, $value, 86400);
	    } 
	    return $value;
	}

	public function getSettlementName() {
	    if (isset($this->settlement)) {
			return $this->settlement->name;
	    } 
		else {
			return false;
	    }
	}
}