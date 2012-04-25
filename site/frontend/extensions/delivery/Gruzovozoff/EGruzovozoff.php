<?php

/**
 * This class represents table 'shop_delivery_egruzovozoff'
 * @property $id
 * @property $weight
 * @property $city
 * @property $zone
 * @property $price
 */
class EGruzovozoff extends CActiveRecord {

	public $additionPropretys = true;

	public function __construct($scenario = 'insert') {
		parent::__construct($scenario);
	}

	public function rules() {
		return array(
			array('id', 'numerical', 'integerOnly' => true),
			array('city, weight', 'required'),
			array('id, price, city, zone, weight', 'safe'),
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @return Delivery the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'shop_delivery_egruzovozoff';
	}
	
	public function primaryKey() {
		return 'id';
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'weight' => 'Вес товара',
			'city' => 'Город',
			'zone' => 'Зона',
			'price' => 'Цена',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		$criteria = new CDbCriteria;
		$criteria->compare('id', $this->id);
		$criteria->compare('price', $this->price, true);
		$criteria->compare('zone', $this->zone, true);
		$criteria->compare('city', $this->city, true);
		$criteria->compare('weight', $this->weight, true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Get array of prices and delivery citites
	 * @param array $param
	 * @return array
	 */

	public function getDeliveryCost($param) {
		if (!isset($param['orderCity'])) {
			return false;
		}
		$orderCitites = array();
		if (is_array($param['orderCity'])) {
			$badKey = array_search("Москва", $param['orderCity']);
			if ($badKey !== false) {
				unset($param['orderCity'][$badKey]);
			}
			$orderCitites = array_unique($param['orderCity']);
		}
		else {
			$orderCitites = array($param['orderCity']);
		}
		Yii::import('ext.delivery.Gruzovozoff.EGruzovozoffTarif');
		$tarifs = EGruzovozoffTarif::model()->getCosts($orderCitites);
		$prices = array();
		foreach ($tarifs as $k => $tarif) {
			$prices[$k]['price'] = $tarif['price'];
			$prices[$k]['destination'] = $tarif['destination'];
			$this->price = $prices[$k]['price'];
			$this->city = $prices[$k]['destination'];
			$this->weight = $param['orderWeight'];
		}
		return $prices;
	}

	public function getForm($param) {
		$this->weight = $param['orderWeight'];
		$params = array(
			'elements' => array(
				__CLASS__ => array(
					'type' => 'form',
					'elements' => array(
						'city' => array(
							'type' => 'text',
						),
						'zone' => array(
							'type' => 'hidden',
						),
						'price' => array(
							'type' => 'hidden',
						),
						'weight' => array(
							'type' => 'hidden',
						)
					),
				),
			),
		);
		return $params;
	}

	public function getSuccessForm() {
		$params = array(
			'elements' => array(
				__CLASS__ => array(
					'type' => 'form',
					'elements' => array(
						'city' => array(
							'type' => 'text',
						),
						'zone' => array(
							'type' => 'hidden',
						),
						'price' => array(
							'type' => 'hidden',
						),
						'weight' => array(
							'type' => 'hidden',
						)
					),
				),
			),
		);
		return $params;
	}

	public function getHiddenForm() {
		$params = array(
			'elements' => array(
				__CLASS__ => array(
					'type' => 'form',
					'elements' => array(
						'city' => array(
							'type' => 'hidden',
						),
						'zone' => array(
							'type' => 'hidden',
						),
						'price' => array(
							'type' => 'hidden',
						),
						'weight' => array(
							'type' => 'hidden',
						)
					),
				),
			),
		);
		return $params;
	}

	public function getDestination() {
		return $this->city;
	}

}

?>