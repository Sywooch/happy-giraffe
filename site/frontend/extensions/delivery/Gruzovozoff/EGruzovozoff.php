<?php

class EGruzovozoff extends CActiveRecord {

	public $additionPropretys = true;

	public function __construct($scenario='insert') {
		parent::__construct($scenario);
	}

	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'numerical', 'integerOnly' => true),
			array('Gff_city, Gff_weight', 'required'),
			array('id, Gff_price, Gff_city, Gff_zone, Gff_weight', 'safe'),
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
			'Gff_price' => 'Price',
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
		$criteria->compare('Gff_price', $this->Gff_price, true);
		$criteria->compare('Gff_zone', $this->Gff_zone, true);
		$criteria->compare('Gff_city', $this->Gff_city, true);
		$criteria->compare('Gff_weight', $this->Gff_weight, true);

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

		Yii::import('ext.delivery.Gruzovozoff.EGruzovozoffTarif');
		$tarifs = Yii::app()->db->createCommand()
				->where(array('in', EGruzovozoffTarif::model()->tableName() . '.tarif_city', $searchCities))
				->from(EGruzovozoffTarif::model()->tableName())
				->queryAll();

		$prices = array();
		foreach ($tarifs as $k => $tarif) {
			$prices[$k]['price'] = $tarif['tarif_price'];
			$prices[$k]['destination'] = $tarif['tarif_city'];
			$this->Gff_price = $prices[$k]['price'];
			$this->Gff_zone = $tarif['tarif_zone'];
			$this->Gff_city = $prices[$k]['destination'];
			$this->Gff_weight = $param['orderWeight'];
		}

		return $prices;
	}

	public function getForm($param) {
		Yii::import('ext.delivery.Gruzovozoff.EGruzovozoffTarif');
		$criteria = new CDbCriteria;
		$criteria->compare('tarif_city', $param['orderCity'], true);
		$cityValues = EGruzovozoffTarif::model()->findAll($criteria);
		$cities = array();
		if ($cityValues) {
			//Если нашли город из заказа в списке городов то ставим его первым в списке
			foreach ($cityValues as $city) {
				$cities[$city->tarifzones_city] = $city->tarifzones_city;
			}
		}

		//Добавляем полный список городов для доставки    
		$cityValues = EGruzovozoffTarif::model()->findAll();
		foreach ($cityValues as $city) {
			$cities[$city->tarif_city] = $city->tarif_city;
		}

		$this->Gff_weight = $param['orderWeight'];

		$params = array(
			'elements' => array(
				__CLASS__ => array(
					'type' => 'form',
					'elements' => array(
						'Gff_city' => array(
							'type' => 'text',
						),
						'Gff_zone' => array(
							'type' => 'hidden',
						),
						'Gff_price' => array(
							'type' => 'hidden',
						),
						'Gff_weight' => array(
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
						'Gff_city' => array(
							'type' => 'text',
						),
						'Gff_zone' => array(
							'type' => 'hidden',
						),
						'Gff_price' => array(
							'type' => 'hidden',
						),
						'Gff_weight' => array(
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
						'Gff_city' => array(
							'type' => 'hidden',
						),
						'Gff_zone' => array(
							'type' => 'hidden',
						),
						'Gff_price' => array(
							'type' => 'hidden',
						),
						'Gff_weight' => array(
							'type' => 'hidden',
						)
					),
				),
			),
		);
		return $params;
	}

	public function getDestination() {
		return $this->Gff_city;
	}

}

?>