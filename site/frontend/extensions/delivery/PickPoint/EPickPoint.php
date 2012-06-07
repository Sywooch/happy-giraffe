<?php

/**
 * This class represents table 'shop_delivery_epickpoint'
 * @property $id
 * @property $city
 * @property $address
 * @property $price
 * @property $pickpoint_id
 */
class EPickPoint extends CActiveRecord {

	public $additionPropretys = true;

	public function __construct($scenario = 'insert') {
		parent::__construct($scenario);
	}

	public function rules() {
		return array(
			array('id', 'numerical', 'integerOnly' => true),
			array('city, address', 'length', 'min' => 1, 'allowEmpty' => false),
			array('id, price, city, address, pickpoint_id', 'safe'),
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
		return 'shop_delivery_epickpoint';
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'price' => 'Price',
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
		$criteria->compare('city', $this->city, true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
		));
	}

	public function getDeliveryCost($param) {

		$orderCities = $this->getOrderCities($param);
		if ($orderCities === false) {
			return false;
		}

		Yii::import('ext.delivery.PickPoint.EPickPointTarif');
		$condition = new CDbCriteria();
		$condition->addInCondition('city', $orderCities);

		$tarifs = EPickPointTarif::model()->findAll($condition);

		$prices = array();
		if (isset($tarifs)) {
			foreach ($tarifs as $k => $tarif) {
				$prices[$k]['price'] = $tarif['price'];
				$prices[$k]['destination'] = $tarif['city'];
				$this->price = $prices[$k]['price'];
				$this->city = $prices[$k]['destination'];
			}
		} else {
			$this->price = null;
		}
		return $prices;
	}

	public function getForm($param) {
		
		$orderCities = $this->getOrderCities($param);
		if ($orderCities === false) {
			return false;
		}
		Yii::import('ext.delivery.PickPoint.EPickPointTarif');
		$condition = new CDbCriteria();
		$condition->addInCondition('city', $orderCities);

		$tarif = EPickPointTarif::model()->find($condition);

		$params = array(
			'elements' => array(
				__CLASS__ => array(
					'type' => 'form',
					'elements' => array(
						'city' => array(
							'type' => 'hidden',
						),
						'price' => array(
							'type' => 'hidden',
						),
						'address' => array(
							'type' => 'hidden',
						),
						'pickpoint_id' => array(
							'type' => 'hidden',
						),
						Yii::app()->controller->renderPartial('ext.delivery.PickPoint._form', array('orderCity' => $tarif['pickgoname']), true),
					),
				),
			),
		);
		return $params;
	}
	
	
	protected function getOrderCities($param) {
		if (!isset($param['orderCity'])) {
			return false;
		}
		$searchCities = array();
		if (is_array($param['orderCity'])) {
			$searchCities = $param['orderCity'];
		} 
		else {
			$searchCities = array($param['orderCity']);
		}
		return $searchCities;
	}

	public function getSuccessForm($param) {
		$params = array(
			'elements' => array(
				__CLASS__ => array(
					'type' => 'form',
					'elements' => array(
						'city' => array(
							'type' => 'hidden',
						),
						'price' => array(
							'type' => 'hidden',
						),
						'address' => array(
							'type' => 'text',
						),
						'pickpoint_id' => array(
							'type' => 'hidden',
						),
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
						'price' => array(
							'type' => 'text',
						),
						'address' => array(
							'type' => 'text',
						),
						'pickpoint_id' => array(
							'type' => 'hidden',
						)
					),
				),
			),
		);
		return $params;
	}

	public function getSettingsUrl() {
		return CHtml::link("Выбрать", "#", array('onclick' => "PickPoint.open(my_function, options);return false"));
	}

	public function getDestination() {
		return $this->address;
	}

}

?>