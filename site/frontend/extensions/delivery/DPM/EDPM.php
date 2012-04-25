<?php

class EDPM extends CActiveRecord {

	public $additionPropretys = true;

	public function __construct($scenario='insert') {
		parent::__construct($scenario);
	}

	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, price', 'numerical', 'integerOnly' => true),
			array('id, price, address, is_express', 'safe'),
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
		return 'shop__delivery_edpm';
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
			'price' => 'Price',
			'is_express' => 'Экспресс доставка'
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
		$criteria->compare('price', $this->price, true);

		return new CActiveDataProvider(get_class($this), array(
					'criteria' => $criteria,
				));
	}

	public function getDeliveryCost($param) {
		$searchCities = array();

		if (is_array($param['orderCity'])) {
			$searchCities = $param['orderCity'];
		} else {
			if (isset($param['orderCity'])) {
				$searchCities = array($param['orderCity']);
			} else {
				return false;
			}
		}
		$prices = array();
		if (in_array("Москва", $searchCities)) {
			$k = 1;
			$prices[$k]['destination'] = "Москва";
			Yii::import('ext.delivery.DPM.EDPMTarif');
			$prices[$k]['price'] = EDPMTarif::model()->getDeliveryCostByOrderPrice($param['orderPrice']);
			$this->price = $prices[$k]['price'];
			$this->address = $prices[$k]['destination'];
		}

		return $prices;
	}

	public function getForm() {
		$params = array(
			'elements' => array(
				__CLASS__ => array(
					'type' => 'form',
					'elements' => array(
						'price' => array(
							'type' => 'hidden',
						),
						'address' => array(
							'type' => 'hidden',
						),
						'<br>',
						'<label class="indent">',
						'is_express' => array(
							'type' => 'checkbox',
						),
						'description' => '* За экспресс будет взиматься дополнительная оплата, которая зависит от пробок на дорогах,  станции метро. При звонке менеджер магазина сообщит точную сумму за экспресс-доставку.',
						'</label>',
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
						'price' => array(
							'type' => 'hidden',
						),
						'address' => array(
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
						'price' => array(
							'type' => 'hidden',
						),
					),
				),
			),
		);
		return $params;
	}

	public function getDestination() {
		return $this->address;
	}

}

?>