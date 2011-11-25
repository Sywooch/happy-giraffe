<?php

/**
 * This is the model class for table "{{contest_user}}".
 *
 * The followings are the available columns in table '{{contest_user}}':
 * @property string $user_id
 * @property string $user_user_id
 * @property string $user_contest_id
 * @property integer $user_work_count
 *
 * getter
 * @property array[int]ContestWork $works
 *
 * rel
 * @property User $user
 * @property Contest $contest
 *
 */
class ContestUser extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ContestUser the static model class
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
		return '{{club_contest_user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_work_count', 'numerical', 'integerOnly'=>true),
			array('user_user_id, user_contest_id', 'length', 'max'=>10),

			array('user_user_id', 'default', 'value' => Yii::app()->user->id),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, user_user_id, user_contest_id, user_work_count', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_user_id'),
			'contest' => array(self::BELONGS_TO, 'Contest', 'user_contest_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'user_user_id' => 'User User',
			'user_contest_id' => 'User Contest',
			'user_work_count' => 'User Work Count',
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

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('user_user_id',$this->user_user_id,true);
		$criteria->compare('user_contest_id',$this->user_contest_id,true);
		$criteria->compare('user_work_count',$this->user_work_count);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getWorks()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('work_user_id', $this->user_user_id);
		$criteria->compare('work_contest_id', $this->user_contest_id);

		return ContestWork::model()->findAll($criteria);
	}
}