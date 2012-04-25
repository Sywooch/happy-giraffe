<?php

class EDZPM extends CActiveRecord {

	public $additionPropretys = true;

	public function __construct($scenario='insert') {
		parent::__construct($scenario);
	}

	public function rules() {
		return array(
			array('id', 'numerical', 'integerOnly' => true),
			array('city', 'required'),
			array('id, price, city', 'safe'),
		);
	}

	public function init() {
		
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @return Delivery the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'shop_delivery_edzpm';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'price' => 'Цена',
			'city' => 'Выберите город',
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
		Yii::import('ext.delivery.DZPM.EDZPMCityZoneLink');
		Yii::import('ext.delivery.DZPM.EDZPMZone');
		$cityId = $param['orderCityId'];
        // TODO lnghost fix
		$city = isset($param['orderCity'][0]) ? $param['orderCity'][0] : false;
		if (!$cityId) {
			return 0;
		}
		$tr = EDZPMZone::model()->findAll();
		$zoneId = EDZPMCityZoneLink::model()->getZoneByCityId((int)$cityId);
		$price = EDZPMZone::model()->getPriceByZoneId((int)$zoneId);
		$prices = array();
		$prices[0]['price'] = $price;
		$prices[0]['destination'] = $city;
		$prices[0]['orderCityId'] = $cityId;
		$this->price = $price;
		$this->city = $city;
		if (!$price)
			$this->price = null;
		return $prices;
	}

	public function getForm($param) {
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
						'price' => array(
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
						'price' => array(
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