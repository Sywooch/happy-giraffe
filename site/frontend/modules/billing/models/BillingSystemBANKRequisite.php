<?php

/**
 * This is the model class for table "billing__system_BANK_requisites".
 *
 * The followings are the available columns in table 'billing__system_BANK_requisites':
 * @property integer $requisite_id
 * @property string $requisite_name
 * @property string $requisite_account
 */
class BillingSystemBANKRequisite extends HActiveRecord
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
		return 'billing__system_BANK_requisites';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('requisite_name, requisite_account, requisite_bank', 'required'),
			array('requisite_bik, requisite_cor_account, requisite_inn, requisite_kpp', 'required'),
			array('requisite_bank_address', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('requisite_id, requisite_name, requisite_account, requisite_bank, requisite_bank_address, requisite_cor_account,requisite_bik,requisite_inn,requisite_kpp', 'safe', 'on'=>'search'),
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
			'requisite_id' => 'Id',
			'requisite_name' => 'Получатель',
			'requisite_account' => 'Расчетный счет',
			'requisite_bank' => 'Название банка',
			'requisite_bank_address'=> 'Адрес банка',
			'requisite_bik' => 'БИК',
			'requisite_cor_account' => 'Корр. счет',
			'requisite_inn'=> 'ИНН',
			'requisite_kpp'=> 'КПП'
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

		$criteria->compare('requisite_id',$this->requisite_id);
		$criteria->compare('requisite_name',$this->requisite_name,true);
		$criteria->compare('requisite_account',$this->requisite_account,true);
		$criteria->compare('requisite_bank',$this->requisite_bank,true);
		$criteria->compare('requisite_bank_address',$this->requisite_bank_address,true);
		$criteria->compare('requisite_bik',$this->requisite_bik,true);
		$criteria->compare('requisite_cor_account',$this->requisite_cor_account,true);
		$criteria->compare('requisite_inn',$this->requisite_inn,true);
		$criteria->compare('requisite_kpp',$this->requisite_kpp,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}