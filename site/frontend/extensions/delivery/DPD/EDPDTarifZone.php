<?php
/**
 * This class represents table 'shop_delivery_edpd_tarifzone'
 * @property $id
 * @property $zone
 * @property $city
 */
class EDPDTarifZone extends CActiveRecord {
	
	public function __construct($scenario = 'insert') {
		parent::__construct($scenario);
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	
	public function tableName() {
		return 'shop_delivery_edpd_tarifzone';
	}
	
	public function primaryKey() {
		return 'id';
	}
	
	public function rules() {
		return array(
			array('id, zone', 'numerical', 'integerOnly' => true),
			array('city', 'required'),
			array('id, zone, city', 'safe'),
		);
	}
	
	public function relations() {
		return array(
			'tarif' => array(self::BELONGS_TO, 'EDPDTarif', 'zone'),
		);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'zone' => 'Цена',
			'city' => 'Город'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id);
		$criteria->compare('zone', $this->zone, true);
		$criteria->compare('city', $this->city, true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
		));
	}
}