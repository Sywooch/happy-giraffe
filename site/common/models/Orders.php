<?php

/**
 * This is the model class for table "orders".
 *
 * The followings are the available columns in table 'orders':
 * @property integer $id
 * @property integer $user_id
 * @property string $number
 * @property string $item_total
 * @property string $total
 * @property string $created_at
 * @property string $updated_at
 * @property string $state
 * @property string $adjustment_total
 * @property string $credit_total
 * @property string $completed_at
 * @property integer $bill_address_id
 * @property integer $ship_address_id
 * @property string $payment_total
 * @property integer $shipping_method_id
 * @property string $shipment_state
 * @property string $payment_state
 * @property string $email
 * @property string $special_instructions
 */
class Orders extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Orders the static model class
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
		return 'orders';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, bill_address_id, ship_address_id, shipping_method_id', 'numerical', 'integerOnly'=>true),
			array('number', 'length', 'max'=>15),
			array('item_total, total, adjustment_total, credit_total, payment_total', 'length', 'max'=>8),
			array('state, shipment_state, payment_state, email', 'length', 'max'=>255),
			array('created_at, updated_at, completed_at, special_instructions', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, number, item_total, total, created_at, updated_at, state, adjustment_total, credit_total, completed_at, bill_address_id, ship_address_id, payment_total, shipping_method_id, shipment_state, payment_state, email, special_instructions', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'number' => 'Number',
			'item_total' => 'Item Total',
			'total' => 'Total',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'state' => 'State',
			'adjustment_total' => 'Adjustment Total',
			'credit_total' => 'Credit Total',
			'completed_at' => 'Completed At',
			'bill_address_id' => 'Bill Address',
			'ship_address_id' => 'Ship Address',
			'payment_total' => 'Payment Total',
			'shipping_method_id' => 'Shipping Method',
			'shipment_state' => 'Shipment State',
			'payment_state' => 'Payment State',
			'email' => 'Email',
			'special_instructions' => 'Special Instructions',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('number',$this->number,true);
		$criteria->compare('item_total',$this->item_total,true);
		$criteria->compare('total',$this->total,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('adjustment_total',$this->adjustment_total,true);
		$criteria->compare('credit_total',$this->credit_total,true);
		$criteria->compare('completed_at',$this->completed_at,true);
		$criteria->compare('bill_address_id',$this->bill_address_id);
		$criteria->compare('ship_address_id',$this->ship_address_id);
		$criteria->compare('payment_total',$this->payment_total,true);
		$criteria->compare('shipping_method_id',$this->shipping_method_id);
		$criteria->compare('shipment_state',$this->shipment_state,true);
		$criteria->compare('payment_state',$this->payment_state,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('special_instructions',$this->special_instructions,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}