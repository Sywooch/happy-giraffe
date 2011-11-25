<?php

class EPickPoint extends CActiveRecord {

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
	    array('pickpoint_city, pickpoint_address', 'length', 'min' => 1, 'allowEmpty' => false),
	    array('id, pickpoint_price, pickpoint_city, pickpoint_address, pickpoint_id', 'safe'),
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
	    'pickpoint_price' => 'Price',
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
	$criteria->compare('pickpoint_price', $this->pickpoint_price, true);
	$criteria->compare('pickpoint_city', $this->pickpoint_city, true);

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
		      `pickpoint_city` VARCHAR(255)  NOT NULL,
		      `pickpoint_address` VARCHAR(255)  NOT NULL,
		      `pickpoint_price` INTEGER(255)  NOT NULL,	
		      `pickpoint_id` VARCHAR(255)  NOT NULL,	
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

	Yii::import('ext.delivery.PickPoint.EPickPointTarif');
	$condition = new CDbCriteria();
	$condition->addInCondition('tarif_city', $searchCities); 

	$tarifs = EPickPointTarif::model()->findAll($condition);

	$prices = array();
	if (isset($tarifs)) {
	    foreach ($tarifs as $k => $tarif) {
		$prices[$k]['price'] = $tarif['tarif_price'];
		$prices[$k]['destination'] = $tarif['tarif_city'];
		$this->pickpoint_price = $prices[$k]['price'];
		$this->pickpoint_city = $prices[$k]['destination'];
//		$this->pickpoint_address = null;//$tarif['tarif_pickgoname'];//$prices[$k]['destination'];
	    }
	} else {
	    $this->pickpoint_price = NUll;
	}
	
	return $prices;
    }

    public function getForm($param) {
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

	Yii::import('ext.delivery.PickPoint.EPickPointTarif');
	$condition = new CDbCriteria();
	$condition->addInCondition('tarif_city', $searchCities); 

	$tarif = EPickPointTarif::model()->find($condition);
	
	$params = array(
	    'elements' => array(
		__CLASS__ => array(
		    'type' => 'form',
		    'elements' => array(
			'pickpoint_city' => array(
			    'type' => 'hidden',
			),
			'pickpoint_price' => array(
			    'type' => 'hidden',
			),
			'pickpoint_address' => array(
			    'type' => 'hidden',
			),
			'pickpoint_id' => array(
			    'type' => 'hidden',
			),
			Yii::app()->controller->renderPartial('ext.delivery.PickPoint._form', array('orderCity'=>$tarif['tarif_pickgoname']), true),
		    ),
		),
	    ),
	);
	return $params;
    }
    
    public function getSuccessForm($param) {
	$params = array(
	    'elements' => array(
		__CLASS__ => array(
		    'type' => 'form',
		    'elements' => array(
			'pickpoint_city' => array(
			    'type' => 'hidden',
			),
			'pickpoint_price' => array(
			    'type' => 'hidden',
			),
			'pickpoint_address' => array(
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
			'pickpoint_city' => array(
			    'type' => 'hidden',
			),
			'pickpoint_price' => array(
			    'type' => 'text',
			),
			'pickpoint_address' => array(
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
	return CHtml::link("Выбрать", "#", array('onclick'=>"PickPoint.open(my_function, options);return false"));;
    }
    
    public function getDestination() {
	return $this->pickpoint_address;
    }

}

?>