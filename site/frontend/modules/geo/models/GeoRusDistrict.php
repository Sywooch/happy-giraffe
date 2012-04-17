<?php

/**
 * This is the model class for table "geo_rus_district".
 *
 * The followings are the available columns in table 'geo_rus_district':
 * @property string $id
 * @property string $name
 * @property string $region_id
 */
class GeoRusDistrict extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return GeoRusDistrict the static model class
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
		return '{{geo__rus_district}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, region_id', 'required'),
			array('name', 'length', 'max'=>255),
			array('region_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, region_id', 'safe'),
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
			'region_id' => 'Region',
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
		$criteria->compare('region_id',$this->region_id,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	public function searchDistrict() {
	    $criteria = new CDbCriteria;

	    $criteria->compare('id', $this->id);

	    return new CActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
		));
	}

	public function getDistrict($region_id=null) {
	    $vid = md5(__CLASS__ . __FUNCTION__ . $region_id);
	    $value = Yii::app()->cache->get($vid);
	    if (!$value) {
			$models = $this->findAll(($region_id) ? 'region_id=' . $region_id : null);
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