<?php

/**
 * This is the model class for table "{{_delivery}}".
 *
 * The followings are the available columns in table '{{_delivery}}':
 * @property integer $id
 * @property string $delivery_name
 * @property integer $delivery_is_install
 * @property integer $order_id
 * @property integer $delivery_id
 * @property integer $delivery_cost
 */
class Delivery extends HActiveRecord
{
	static $entitys = array();

	/**
	 * Returns the static model of the specified AR class.
	 * @return Delivery the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'shop_delivery';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('delivery_is_install, order_id, delivery_id', 'numerical', 'integerOnly' => true),
//			array('delivery_cost', 'float'),
			array('delivery_name', 'length', 'max' => 250),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, delivery_name, delivery_is_install, order_id, delivery_id, delivery_cost', 'safe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'delivery_name' => 'Delivery Name',
			'delivery_is_install' => 'Delivery Is Install',
			'order_id' => 'Order',
			'delivery_id' => 'Delivery',
			'delivery_cost' => 'Delivery Cost',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('delivery_name', $this->delivery_name, true);
		$criteria->compare('delivery_is_install', $this->delivery_is_install);
		$criteria->compare('order_id', $this->order_id);
		$criteria->compare('delivery_id', $this->delivery_id);
		$criteria->compare('delivery_cost', $this->delivery_cost);

		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
			));
	}

	public function beforeSave()
	{

		$condition = new CDbCriteria;
//	$condition->compare('delivery_name', $this->delivery_name, true);
		$condition->compare('order_id', $this->order_id);
		$models = $this->findAll($condition);
		foreach($models as $model)
			$model->delete();

		parent::beforeSave();
		return true;
	}

	public function getForm()
	{
		$params = array(
			'elements' => array(
				__CLASS__ => array(
					'type' => 'form',
					'elements' => array(
						'order_id' => array(
							'type' => 'hidden',
						),
						'delivery_name' => array(
							'type' => 'hidden',
						),
						'delivery_cost' => array(
							'type' => 'text',
						),
					),
				),
			),
		);
		return $params;
	}

	public function getShowForm()
	{
		$params = array(
			'elements' => array(
				__CLASS__ => array(
					'type' => 'form',
					'elements' => array(
						'order_id' => array(
							'type' => 'text',
						),
						'delivery_name' => array(
							'type' => 'text',
						),
						'delivery_cost' => array(
							'type' => 'text',
						),
					),
				),
			),
		);
		return $params;
	}

	public function getHiddenForm()
	{
		$params = array(
			'elements' => array(
				__CLASS__ => array(
					'type' => 'form',
					'elements' => array(
						'order_id' => array(
							'type' => 'hidden',
						),
						'delivery_name' => array(
							'type' => 'hidden',
						),
						'delivery_cost' => array(
							'type' => 'hidden',
						),
					),
				),
			),
		);
		return $params;
	}

	public static function getClassName()
	{
		return __CLASS__;
	}

	public static function getCostByOrder($id) {
		if(isset(self::$entitys[$id])) {
			$module = self::$entitys[$id];
		}
		else{
			$module = self::$entitys[$id] = self::model()->find('order_id=' . $id);
		}
		if(isset($module)) {
			return $module->delivery_cost;
		}
		else{
			return 0;
		}
	}

	public static function getAdressByOrder($id) {
		if(isset(self::$entitys[$id])) {
			$module = self::$entitys[$id];
		}
		else {
			$module = self::$entitys[$id] = self::model()->find('order_id=' . $id);
		}
		if(isset($module)) {
		    $ext = Yii::app()->getModule('delivery')->components[$module->delivery_name]['ext'];
		    $mn = Yii::app()->getModule('delivery')->components[$module->delivery_name]['class_name'];
		    Yii::import($ext);
		    $modelDelivery = CActiveRecord::model($mn)->findByPk($module->delivery_id);
		    return $modelDelivery->getDestination();
		}
		else {
			return 0;
		}
	}
	
	public static function getMethodByOrder($id) {
		if(isset(self::$entitys[$id])) {
			$module = self::$entitys[$id];
		}
		else {
			$module = self::$entitys[$id] = self::model()->find('order_id=' . $id);
		}
		if(isset($module)) {
		    return Yii::app()->getModule('delivery')->components[$module->delivery_name]['show_name'];
		}
		return null;
	}
	
	/**
	 * Get order information: address, method, cost.
	 * Return associated array.
	 * @param int $orderId 
	 * @return array
	 */
	public static function getOrderInformation($orderId) {
		$info = array();
		$info['method'] = self::getMethodByOrder($orderId);
		$info['cost'] = self::getCostByOrder($orderId);
		$info['adress'] = self::getAdressByOrder($orderId);
		return $info;
	}

}