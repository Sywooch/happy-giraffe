<?php

/**
 * This is the model class for table "{{vaucher}}".
 *
 * The followings are the available columns in table '{{vaucher}}':
 * @property string $vaucher_id
 * @property string $vaucher_code
 * @property string $vaucher_discount
 * @property string $vaucher_time
 * @property string $vaucher_from_time
 * @property string $vaucher_till_time
 * @property string $vaucher_text
 */
class Vaucher extends HActiveRecord
{
	public function behaviors()
	{
		return array(
			'behavior_date' => array(
				'class' => 'ext.I18nDateTimeBehavior',
				'dateOutcomeFormat' => 'dd.MM.yyyy',
				'dateIncomeFormat'=> 'dd.MM.yyyy',
				'fields'=>array(
					'vaucher_from_time'=>'i-date-floor',
					'vaucher_till_time'=>'i-date-ceil',
				)
			)
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @return Vaucher the static model class
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
		return 'shop__vaucher';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vaucher_code, vaucher_discount, vaucher_from_time, vaucher_till_time', 'required'),
			array('vaucher_code', 'length', 'max'=>50),
			array('vaucher_discount, vaucher_time, vaucher_from_time, vaucher_till_time', 'length', 'max'=>10),
			array('vaucher_text', 'safe'),
			
			array('vaucher_discount', 'numerical'),
			
			array('vaucher_time', 'default', 'value' => time()),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('vaucher_id, vaucher_code, vaucher_discount, vaucher_time, vaucher_from_time, vaucher_till_time, vaucher_text', 'safe', 'on'=>'search'),
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
			'vaucher_id' => 'Vaucher',
			'vaucher_code' => 'Код',
			'vaucher_discount' => 'Скидка',
			'vaucher_time' => 'Дата',
			'vaucher_from_time' => 'Дата начала',
			'vaucher_till_time' => 'Дата окончания',
			'vaucher_text' => 'Описание',
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

		$criteria->compare('vaucher_id',$this->vaucher_id);
		$criteria->compare('vaucher_code',$this->vaucher_code,true);
		$criteria->compare('vaucher_discount',$this->vaucher_discount);
		$criteria->compare('vaucher_time',$this->vaucher_time,true);
		$criteria->compare('vaucher_from_time',$this->vaucher_from_time,true);
		$criteria->compare('vaucher_till_time',$this->vaucher_till_time,true);
		$criteria->compare('vaucher_text',$this->vaucher_text,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Find vaucher by code (use from/till condition)
	 * @param string $code Code of vaucher
	 * @return mixed row of vaucher or false if not exists
	 */
	public static function isActive($code)
	{
		return Y::command()
			->select()
			->from(self::model()->tableName())
			->where('vaucher_code=:vaucher_code AND vaucher_from_time<:vaucher_from_time AND vaucher_till_time>:vaucher_till_time', array(
				':vaucher_code'=>$code,
				':vaucher_from_time'=>time(),
				':vaucher_till_time'=>time(),
			))
			->limit(1)
			->queryRow();
	}
}