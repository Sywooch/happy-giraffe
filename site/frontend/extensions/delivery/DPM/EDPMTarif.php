<?php
/**
 * This class represents table shop__delivery_edpm_tarif in database
 * @property $id
 * @property $order_price_from
 * @property $order_price_to
 * @property $price
 */
class EDPMTarif extends CActiveRecord {
	
	public function __construct($scenario = 'insert') {
		parent::__construct($scenario);
	}
	
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	
	public function tableName() {
		return 'shop__delivery_edpm_tarif';
	}
	
	public function primaryKey() {
		return 'id';
	}
	
	public function rules() {
		return array(
			'order_price_from, order_price_to, price', 'numerical', 'integerOnly' => true,
			'order_price_to', 'numerical', 'allowEmpty' => true
		);
	}
	
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'order_price_from' => 'Order Price From',
			'prder_price_to' => 'Order Price To',
			'price' => 'Price'
		);
	}
	
	public function defaultScope() {
		return array(
			'order' => $this->getTableAlias(false, false). '.order_price_from ASC'
		);
	}
	
	/**
	 * Get delivery cost by order price
	 * @param int $orderPrice 
	 * @return int delivery price depends on the $orderPrice
	 */
	public function getDeliveryCostByOrderPrice($orderPrice) {
		$tarifs = $this->findAll();
		if (!$tarifs) {
			throw new CHttpException(400, 'Invalid data in database');
		}
		$lastEntryIndex  = count($tarifs) - 1;
		if ((int)$orderPrice >= $tarifs[$lastEntryIndex]->order_price_from) {
			return 0;
		}
		$ct = new CDbCriteria;
		$ct->addCondition(':order_price >= order_price_from');
		$ct->addCondition(':order_price < order_price_to');
		$ct->addCondition('order_price_to IS NOT NULL');
		$ct->params = array(
			':order_price' => (int) $orderPrice
		);
		$tarif = $this->find($ct);
		if (!$tarif) {
			throw new CHttpException(404, 'Tarif not found');
		}
		return $tarif->price;
	}
}