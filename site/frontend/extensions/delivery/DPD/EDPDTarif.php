<?php

/**
 * This class represents table 'shop_delivery_edpd_tarif'
 * @property $id
 * @property $weight1
 * @property $weight2
 * @property $overload
 * @property $price
 */
class EDPDTarif extends CActiveRecord {
	
	public function __construct($scenario = 'insert') {
		parent::__construct($scenario);
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	
	public function tableName() {
		return 'shop_delivery_edpd_tarif';
	}
	
	public function primaryKey() {
		return 'id';
	}
	
	public function rules() {
		return array(
			array('id, zone', 'numerical', 'integerOnly' => true),
			array('id, zone, weight1, weight2, overload, price', 'safe'),
		);
	}
	
	public function relations() {
		return array(
//			'tarifzone' => array(self::HAS_ONE, 'EDPDTarifZone', 'zone'),
		);
	}
	
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'zone' => 'Зона',
			'weight1' => 'Вес',
			'overload' => 'Overload',
			'price' => 'Цена'
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
		$criteria->compare('weight1', $this->weight, true);
		$criteria->compare('weight2', $this->weight, true);
		$criteria->compare('overload', $this->overload, true);
		$criteria->compare('price', $this->price, true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
		));
	}
	
	/**
	 * Get Tarifs
	 * @param array $cities
	 * @param array $param
	 */
	public function getTarifs(array $cities, $param) {
		if (!$cities) {
			return array();
		}
		Yii::import('ext.delivery.DPD.EDPDTarifZone');
		$tarifs = Yii::app()->db->createCommand()
				->leftjoin(EDPDTarifZone::model()->tableName(), EDPDTarifZone::model()->tableName().'.`zone`= ' . $this->tableName() . '.`zone`')
				->where(
					array('and', 'weight1 <=' . $param['orderWeight'],
						'weight2 >=' . min(array(30, $param['orderWeight'])),
						array('in', EDPDTarifZone::model()->tableName() . '.city', $cities)
					)
				)
				->from($this->tableName())
				->queryAll();
		return $tarifs;
	}
}
