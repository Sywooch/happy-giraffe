<?php

/**
 * This is the model class for table "billing__invoices".
 *
 * The followings are the available columns in table 'billing__invoices':
 * @property string $invoice_id
 * @property string $invoice_order_id
 * @property string $invoice_time
 * @property string $invoice_amount
 * @property string $invoice_currency
 * @property string $invoice_description
 * @property string $invoice_payer_id
 * @property string $invoice_payer_name
 * @property string $invoice_payer_email
 * @property string $invoice_payer_gsm
 * @property integer $invoice_status
 * @property string $invoice_status_time
 * @property string $invoice_paid_amount
 * @property string $invoice_paid_time
 */
class BillingInvoice extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return BillingInvoice the static model class
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
		return 'billing__invoices';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invoice_amount,invoice_currency,invoice_description','required', 'on'=>'create'),
			array('invoice_order_id', 'numerical', 'min'=>0, 'on'=>'create'),
			array('invoice_amount', 'numerical', 'min'=>0.01, 'on'=>'create'),
			array('invoice_currency', 'in', 'range'=>array('RUR'), 'on'=>'create'),
			array('invoice_description', 'length', 'max'=>250,'on'=>'create'),
			array('invoice_payer_id', 'numerical', 'min'=>0, 'on'=>'create'),
			array('invoice_payer_name', 'length', 'max'=>64, 'on'=>'create'),
			array('invoice_payer_email', 'length', 'max'=>128, 'on'=>'create'),
			array('invoice_payer_gsm', 'length', 'max'=>16, 'on'=>'create'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('invoice_id, invoice_order_id, invoice_time, invoice_amount, invoice_currency, invoice_description, invoice_payer_id, invoice_payer_name, invoice_payer_email, invoice_payer_gsm, invoice_status, invoice_status_time, invoice_paid_amount, invoice_paid_time', 'safe', 'on'=>'search'),
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
			'invoice_id' => 'Invoice',
			'invoice_order_id' => 'Invoice Order',
			'invoice_time' => 'Invoice Time',
			'invoice_amount' => 'Invoice Amount',
			'invoice_currency' => 'Invoice Currency',
			'invoice_description' => 'Invoice Description',
			'invoice_payer_id' => 'Invoice Payer',
			'invoice_payer_name' => 'Invoice Payer Name',
			'invoice_payer_email' => 'Invoice Payer Email',
			'invoice_payer_gsm' => 'Invoice Payer Gsm',
			'invoice_status' => 'Invoice Status',
			'invoice_status_time' => 'Invoice Status Time',
			'invoice_paid_amount' => 'Invoice Paid Amount',
			'invoice_paid_time' => 'Invoice Paid Time',
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

		$criteria->compare('invoice_id',$this->invoice_id,true);
		$criteria->compare('invoice_order_id',$this->invoice_order_id,true);
		$criteria->compare('invoice_time',$this->invoice_time,true);
		$criteria->compare('invoice_amount',$this->invoice_amount,true);
		$criteria->compare('invoice_currency',$this->invoice_currency,true);
		$criteria->compare('invoice_description',$this->invoice_description,true);
		$criteria->compare('invoice_payer_id',$this->invoice_payer_id,true);
		$criteria->compare('invoice_payer_name',$this->invoice_payer_name,true);
		$criteria->compare('invoice_payer_email',$this->invoice_payer_email,true);
		$criteria->compare('invoice_payer_gsm',$this->invoice_payer_gsm,true);
		$criteria->compare('invoice_status',$this->invoice_status);
		$criteria->compare('invoice_status_time',$this->invoice_status_time,true);
		$criteria->compare('invoice_paid_amount',$this->invoice_paid_amount,true);
		$criteria->compare('invoice_paid_time',$this->invoice_paid_time,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	function orderProceed()
	{
		call_user_func(Yii::app()->controller->module->callbackOrderProceed, $this);
		$this->invoice_order_proceed_time = time();
		$this->update(array('invoice_order_proceed_time'));
	}
	
	function orderPaid()
	{
		call_user_func(Yii::app()->controller->module->callbackOrderPaid, $this);
		$this->invoice_order_paid_time = time();
		$this->update(array('invoice_order_paid_time'));
	}
}