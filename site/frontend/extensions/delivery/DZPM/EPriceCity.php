<?php

class EPriceCity extends CActiveRecord {

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
	    array('id, price', 'numerical', 'integerOnly' => true),
//			array('price', 'required'),
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
	    'price' => 'Price',
	    'city'=>'City'
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
	$criteria->compare('city', $this->city, true);

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
		      `price` VARCHAR(255)  NOT NULL,	  
		      `city` VARCHAR(255)  NOT NULL,	
		      PRIMARY KEY (`id`)
		    ) ENGINE = InnoDB
		    CHARACTER SET utf8 COLLATE utf8_general_ci;';

	$connection = Yii::app()->db;
	$command = $connection->createCommand($sql);
	$command->execute();
    }

    public function getForm() {
	$params = array(
	    'type' => 'form',
	    'elements' => array(
		'city' => array(
		    'type' => 'hidden',
		),
		
	    ),
	    'buttons' => array(
		'login' => array(
		    'type' => 'submit',
		    'label' => 'Агумсссс',
		),
	    ),
	);

	return new CForm($params, $this);
    }

}

?>