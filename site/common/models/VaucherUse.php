<?php

/**
 * This is the model class for table "{{vaucher_use}}".
 *
 * The followings are the available columns in table '{{vaucher_use}}':
 * @property string $use_id
 * @property string $use_user_id
 * @property string $use_vaucher_id
 * @property string $use_time
 */
class VaucherUse extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VaucherUse the static model class
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
		return 'shop__vaucher_use';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('use_user_id, use_vaucher_id, use_time', 'required'),
			array('use_user_id, use_vaucher_id, use_time', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('use_id, use_user_id, use_vaucher_id, use_time', 'safe', 'on'=>'search'),
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
			'use_id' => 'Use',
			'use_user_id' => 'Use User',
			'use_vaucher_id' => 'Use Vaucher',
			'use_time' => 'Use Time',
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

		$criteria->compare('use_id',$this->use_id,true);
		$criteria->compare('use_user_id',$this->use_user_id,true);
		$criteria->compare('use_vaucher_id',$this->use_vaucher_id,true);
		$criteria->compare('use_time',$this->use_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}