<?php

/**
 * This is the model class for table "vaccine_user_vote".
 *
 * The followings are the available columns in table 'vaccine_user_vote':
 * @property integer $id
 * @property integer $user_id
 * @property integer $baby_id
 * @property integer $vaccine_date_id
 * @property integer $vote
 */
class VaccineUserVote extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VaccineUserVote the static model class
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
		return 'vaccine_user_vote';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, baby_id, vaccine_date_id, vote', 'required'),
			array('user_id, baby_id, vaccine_date_id, vote', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, baby_id, vaccine_date_id, vote', 'safe', 'on'=>'search'),
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
			'baby_id' => 'Baby',
			'vaccine_date_id' => 'Vaccine Date',
			'vote' => 'Vote',
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
		$criteria->compare('baby_id',$this->baby_id);
		$criteria->compare('vaccine_date_id',$this->vaccine_date_id);
		$criteria->compare('vote',$this->vote);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}