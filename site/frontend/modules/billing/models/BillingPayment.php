<?php

/**
 * This is the model class for table "billing__invoice_payments".
 *
 * The followings are the available columns in table 'billing__invoice_payments':
 * @property string $payment_id
 * @property string $payment_system_id
 * @property string $payment_invoice_id
 * @property string $payment_time
 * @property string $payment_amount
 * @property string $payment_currency
 * @property string $payment_description
 * @property string $payment_accept_time
 * @property string $payment_accept_info
 * @property string $payment_notice_time
 * @property string $payment_notice_info
 * @property string $payment_result_time
 * @property string $payment_result_info
 * @property integer $payment_status
 * @property string $payment_status_time
 * @property string $payment_status_code
 * @property string $payment_status_reason
 * @property string $payment_status_admin_id
 */
class BillingPayment extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return BillingPayment the static model class
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
		return 'billing__invoice_payments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('payment_time','default','value'=>time(), 'on'=>'create'),
			array('payment_invoice_id', 'numerical', 'integerOnly'=>true, 'min'=>0, 'on'=>'create'),
			array('payment_amount', 'numerical', 'min'=>0.01, 'on'=>'create'),
			array('payment_currency', 'in', 'range'=>array('RUR'), 'on'=>'create'),
			array('payment_system_id', 'in', 'range'=>array_keys(BillingSystem::enum('system_id,system_code')), 'on'=>'create'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('payment_id, payment_system_id, payment_invoice_id, payment_time, payment_amount, payment_currency, payment_description, payment_accept_time, payment_accept_info, payment_notice_time, payment_notice_info, payment_result_time, payment_result_info, payment_status, payment_status_time, payment_status_code, payment_status_reason, payment_status_admin_id', 'safe', 'on'=>'search'),
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
			'system'=>array(self::BELONGS_TO, 'BillingSystem', 'payment_system_id'),
			'invoice'=>array(self::BELONGS_TO, 'BillingInvoice', 'payment_invoice_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'payment_id' => 'Payment',
			'payment_system_id' => 'Payment System',
			'payment_invoice_id' => 'Payment Invoice',
			'payment_time' => 'Payment Time',
			'payment_amount' => 'Payment Amount',
			'payment_currency' => 'Payment Currency',
			'payment_description' => 'Payment Description',
			'payment_accept_time' => 'Payment Accept Time',
			'payment_accept_info' => 'Payment Accept Info',
			'payment_notice_time' => 'Payment Notice Time',
			'payment_notice_info' => 'Payment Notice Info',
			'payment_result_time' => 'Payment Result Time',
			'payment_result_info' => 'Payment Result Info',
			'payment_status' => 'Payment Status',
			'payment_status_time' => 'Payment Status Time',
			'payment_status_code' => 'Payment Status Code',
			'payment_status_reason' => 'Payment Status Reason',
			'payment_status_admin_id' => 'Payment Status Admin',
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

		$criteria->compare('payment_id',$this->payment_id,true);
		$criteria->compare('payment_system_id',$this->payment_system_id,true);
		$criteria->compare('payment_invoice_id',$this->payment_invoice_id,true);
		$criteria->compare('payment_time',$this->payment_time,true);
		$criteria->compare('payment_amount',$this->payment_amount,true);
		$criteria->compare('payment_currency',$this->payment_currency,true);
		$criteria->compare('payment_description',$this->payment_description,true);
		$criteria->compare('payment_accept_time',$this->payment_accept_time,true);
		$criteria->compare('payment_accept_info',$this->payment_accept_info,true);
		$criteria->compare('payment_notice_time',$this->payment_notice_time,true);
		$criteria->compare('payment_notice_info',$this->payment_notice_info,true);
		$criteria->compare('payment_result_time',$this->payment_result_time,true);
		$criteria->compare('payment_result_info',$this->payment_result_info,true);
		$criteria->compare('payment_status',$this->payment_status);
		$criteria->compare('payment_status_time',$this->payment_status_time,true);
		$criteria->compare('payment_status_code',$this->payment_status_code,true);
		$criteria->compare('payment_status_reason',$this->payment_status_reason,true);
		$criteria->compare('payment_status_admin_id',$this->payment_status_admin_id,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	public function invoke($action, $info, $time=null, $status=null)
	{
		$attr_info = "payment_{$action}_info";
		$attr_time = "payment_{$action}_time";

		$this->$attr_info = is_array($info) ?http_build_query($info, null, "\n") :$info;
		$this->$attr_time = $time ?$time :time();

		$update = array($attr_info, $attr_time);

		if (isset($status))
		{
			if (!is_array($status)) $status = array($status);
			if (!isset($status['time'])) $status['time'] = time();

			$this->payment_status = array_shift($status);
			$update[] = 'payment_status';
			foreach($status as $n=>$v) {
				$update[] = $attr = "payment_status_$n";
				$this->$attr = $v;
			}
		}
		$this->update($update);

		if ($action=='accept' && !$this->system->system_prepaid) {
			$this->invoice->orderProceed();
		} 
		if (isset($status) && $status==1) {
			$this->invoice->orderPaid();
			if ($this->system->system_prepaid) {
				$this->invoice->orderProceed();
			}
		}
	}

}