<?php

class EDZPM extends CActiveRecord {

    public $additionPropretys = true;
    
    public $createTable = true;

    public function __construct($scenario='insert') {

	if ($this->createTable)
	    $this->install();
	parent::__construct($scenario);
    }

    public function rules() {
	// NOTE: you should only define rules for those attributes that
	// will receive user inputs.
	return array(
	    array('id', 'numerical', 'integerOnly' => true),
	    array('DZPM_city', 'required'),
	    array('id, DZPM_price, DZPM_city', 'safe'),
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
	    'DZPM_price' => 'Price',
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
	$criteria->compare('DZPM_price', $this->DZPM_price, true);
	$criteria->compare('DZPM_city', $this->DZPM_city, true);

	return new CActiveDataProvider(get_class($this), array(
		    'criteria' => $criteria,
		));
    }

    /*
     * Здесь создаем в базе данных таблицу с настройками этого модуля
     */

    public function install() {

	$sql = 'CREATE TABLE IF NOT EXISTS  {{_delivery_' . __CLASS__ . '}} (
		      `id` INTEGER  NOT NULL AUTO_INCREMENT,
		      `DZPM_price` VARCHAR(255)  NOT NULL,
		      `DZPM_city` VARCHAR(255)  NOT NULL,
		      PRIMARY KEY (`id`)
		    ) ENGINE = InnoDB
		    CHARACTER SET utf8 COLLATE utf8_general_ci;';

	$connection = Yii::app()->db;
	$command = $connection->createCommand($sql);
	$command->execute();
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

	Yii::import('ext.delivery.DZPM.EPriceCity');
	$condition = new CDbCriteria();
	$condition->addInCondition('city', $searchCities);

	$tarifs = EPriceCity::model()->findAll($condition);

	$prices = array();
	if (isset($tarifs)) {
	    foreach ($tarifs as $k => $tarif) {
				
		$prices[$k]['price'] = $tarif['price'];
		$prices[$k]['destination'] = $tarif['city'];

		if ($param['orderPrice'] < 500) {
		    $prices[$k]['price'] += 350;
		}
		if (($param['orderPrice'] >= 500) && ($param['orderPrice'] < 1000)) {
		    $prices[$k]['price'] += 250;
		}
		if (($param['orderPrice'] >= 1000) && ($param['orderPrice'] < 1500)) {
		    $prices[$k]['price'] += 100;
		}
		if (($param['orderPrice'] >= 1500)) {
		    $prices[$k]['price'] += 0;
		}

		$this->DZPM_price = $prices[$k]['price'];
		$this->DZPM_city = $prices[$k]['destination'];
	    }
	} else {
	    $this->DZPM_price = NUll;
	}

	return $prices;
    }

    public function getForm($param) {
	Yii::import('ext.delivery.DZPM.EPriceCity');
	$criteria = new CDbCriteria;
	$criteria->compare('city', $param['orderCity'], true);
	$cityValues = EPriceCity::model()->findAll($criteria);
	$cities = array();
	if ($cityValues) {
	    foreach ($cityValues as $city) {
		$cities[$city->city] = $city->city;
	    }
	    if (count($cities) == 1) {
		$this->DZPM_city = $cityValues->city;
	    }
	}

	$citys = array();

	if ((!$cities) || (count($cities) > 1)) {
	    $EPriceCity = new EPriceCity;

	    $cityValues = Yii::app()->db->createCommand()
		    ->select('city')
		    ->from($EPriceCity->tableName())
		    ->queryAll();

	    $citys = CHtml::listData($cityValues, 'city', 'city');

	    $citys = array_diff($citys, $cities);
	}


	$cities = array_merge($cities, $citys);

	$params = array(
	    'elements' => array(
		__CLASS__ => array(
		    'type' => 'form',
		    'elements' => array(
			'DZPM_city' => array(
			    'type' => 'dropdownlist',
			    'items' => $cities,
			),
			'DZPM_price' => array(
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
			'DZPM_city' => array(
			    'type' => 'text',
			),
			'DZPM_price' => array(
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
			'DZPM_city' => array(
			    'type' => 'hidden',
			),
			'DZPM_price' => array(
			    'type' => 'hidden',
			)
		    ),
		),
	    ),
	);
	return $params;
    }
    
    public function getDestination() {
	return $this->DZPM_city;
    }

}

?>