<?php

/**
 * This is the model class for table "billing__system_payment_form_QIWI".
 *
 * The followings are the available columns in table 'billing__system_payment_form_QIWI':
 * @property integer $requisite_id
 * @property string $requisite_name
 * @property string $requisite_account
 */
class BillingSystemPaymentFormQIWI extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return BillingSystemBANKRequisite the static model class
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
		return 'billing__system_payment_form_QIWI';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('form_gsm', 'required'),
			array('form_gsm', 'match', 'pattern'=>'#^(\d{10})$#'),
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
			'form_id' => 'Id',
			'form_gsm' => 'Номер мобильного QIWI кошелька',
		);
	}


}