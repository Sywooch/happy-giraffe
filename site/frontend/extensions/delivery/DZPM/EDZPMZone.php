<?php

class EDZPMZone extends CActiveRecord {

	public function __construct($scenario = 'insert') {
		parent::__construct($scenario);
	}

	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, price', 'numerical', 'integerOnly' => true),
			array('id, price, title', 'safe'),
		);
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
		return 'shop_delivery_edzpm_zone';
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
			'price' => 'Price',
			'title' => 'title'
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
		$criteria->compare('title', $this->title, true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
		));
	}

	public function getForm() {
		$params = array(
			'type' => 'form',
			'elements' => array(
				'city' => array(
					'type' => 'hidden',
				),
			),
		);
		return new CForm($params, $this);
	}
	
	/**
	 * Return price by zone
	 * @param int $zoneId
	 * @return int
	 */
	public function getPriceByZoneId($zoneId) {
		
		$zone = $this->findByPk($zoneId);
		if (!$zone) {
			return 0;
		}
		return $zone->price;
	}

}
