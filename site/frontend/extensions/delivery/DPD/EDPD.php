<?php

class EDPD extends CActiveRecord {

	public $additionPropretys = true;

	public function __construct($scenario='insert') {

		parent::__construct($scenario);
	}

	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'numerical', 'integerOnly' => true),
			array('DPD_city, DPD_weight', 'required'),
			array('id, DPD_price, DPD_city, DPD_zone, DPD_weight', 'safe'),
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
		return '{{shop__delivery_' . __CLASS__ . '}}';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'DPD_price' => 'Price',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('DPD_price', $this->DPD_price, true);
		$criteria->compare('DPD_zone', $this->DPD_zone, true);
		$criteria->compare('DPD_city', $this->DPD_city, true);
		$criteria->compare('DPD_weight', $this->DPD_weight, true);

		return new CActiveDataProvider(get_class($this), array(
					'criteria' => $criteria,
				));
	}

	/*
	 * Возвращаемые значения массив цен с городами доставки
	 */

	public function getDeliveryCost($param) {
		$searchCities = array();
		if (is_array($param['orderCity'])) {
			if ($k = array_search("Москва", $param['orderCity']))
				unset($param['orderCity'][$k]);
			$searchCities = $param['orderCity'];
		} else {
			if (isset($param['orderCity'])) {
				$searchCities = array($param['orderCity']);
			} else {
				return false;
			}
		}

		if (isset($searchCities[0]) && $searchCities[0] == "Москва")
			return false;

		Yii::import('ext.delivery.DPD.ETarif');
		Yii::import('ext.delivery.DPD.ETarifZones');
		$tarifs = Yii::app()->db->createCommand()
				->leftjoin('{{_delivery_ETarifZones}}', '`{{_delivery_ETarifZones}}`.`tarifzones_zone`=`tarif_zone`')
				->where(array('and', 'tarif_weight1 <=' . $param['orderWeight'],
					'tarif_weight2 >=' . min(array(30, $param['orderWeight'])),
					array('in', '{{_delivery_ETarifZones}}.tarifzones_city', $searchCities)
						)
				)
				->from(ETarif::model()->tableName())
				->queryAll();

		$prices = array();
		foreach ($tarifs as $k => $tarif) {
			$prices[$k]['price'] = $tarif['tarif_price'];
			if ($param['orderWeight'] > 30) {
				$prices[$k]['price'] += ($param['orderWeight'] - 30) * $tarif['tarif_overload'];
			}
			$prices[$k]['destination'] = $tarif['tarifzones_city'];
			$this->DPD_price = $prices[$k]['price'];
			$this->DPD_zone = $tarif['tarif_zone'];
			$this->DPD_city = $prices[$k]['destination'];
			$this->DPD_weight = $param['orderWeight'];
		}

		return $prices;
	}

	public function getForm($param) {
		Yii::import('ext.delivery.DPD.ETarifZones');
		$criteria = new CDbCriteria;
		$criteria->compare('tarifzones_city', $param['orderCity'], true);
		$cityValues = ETarifZones::model()->findAll($criteria);
		$cities = array();
		if ($cityValues) {
			//Если нашли город из заказа в списке городов то ставим его первым в списке
			foreach ($cityValues as $city) {
				$cities[$city->tarifzones_city] = $city->tarifzones_city;
			}
		}

		//Добавляем полный список городов для доставки    
		$cityValues = ETarifZones::model()->findAll();
		foreach ($cityValues as $city) {
			$cities[$city->tarifzones_city] = $city->tarifzones_city;
		}

		$this->DPD_weight = $param['orderWeight'];

		$params = array(
			'elements' => array(
				__CLASS__ => array(
					'type' => 'form',
					'elements' => array(
						'DPD_city' => array(
							'type' => 'text',
						),
						'DPD_zone' => array(
							'type' => 'hidden',
						),
						'DPD_price' => array(
							'type' => 'hidden',
						),
						'DPD_weight' => array(
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
						'DPD_city' => array(
							'type' => 'text',
						),
						'DPD_zone' => array(
							'type' => 'hidden',
						),
						'DPD_price' => array(
							'type' => 'hidden',
						),
						'DPD_weight' => array(
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
						'DPD_city' => array(
							'type' => 'hidden',
						),
						'DPD_zone' => array(
							'type' => 'hidden',
						),
						'DPD_price' => array(
							'type' => 'hidden',
						),
						'DPD_weight' => array(
							'type' => 'hidden',
						)
					),
				),
			),
		);
		return $params;
	}

	public function getDestination() {
		return $this->DPD_city;
	}

}

?>