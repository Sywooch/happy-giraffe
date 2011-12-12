<?php

class ETarifZones extends CActiveRecord {

	public function __construct($scenario='insert') {

		parent::__construct($scenario);
	}

	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, tarifzones_zone', 'numerical', 'integerOnly' => true),
			array('tarifzones_city', 'required'),
			array('id, tarifzones_zone, tarifzones_city', 'safe'),
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
			'tarif' => array(self::BELONGS_TO, 'ETarif', 'tarifzones_zone'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'tarifzones_zone' => 'Price',
			'tarifzones_city' => 'City'
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
		$criteria->compare('tarifzones_zone', $this->tarifzones_zone, true);
		$criteria->compare('tarifzones_city', $this->tarifzones_city, true);

		return new CActiveDataProvider(get_class($this), array(
					'criteria' => $criteria,
				));
	}
}

?>