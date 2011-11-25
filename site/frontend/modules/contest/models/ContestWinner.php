<?php

/**
 * This is the model class for table "{{contest_winner}}".
 *
 * The followings are the available columns in table '{{contest_winner}}':
 * @property string $winner_id
 * @property string $winner_contest_id
 * @property integer $winner_place
 * @property string $winner_prize_id
 * @property string $winner_user_id
 * @property string $winner_work_id
 *
 * rel
 * @property Contest $contest
 * @property Prize $prize
 * @property User $user
 * @property Work $work
 *
 */
class ContestWinner extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ContestWinner the static model class
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
		return '{{club_contest_winner}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('winner_place', 'numerical', 'integerOnly'=>true),
			array('winner_contest_id, winner_prize_id, winner_user_id, winner_work_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('winner_id, winner_contest_id, winner_place, winner_prize_id, winner_user_id, winner_work_id', 'safe', 'on'=>'search'),
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
			'contest' => array(self::BELONGS_TO, 'Contest', 'winner_contest_id'),
			'prize' => array(self::BELONGS_TO, 'ContestPrize', 'winner_prize_id'),
			'user' => array(self::BELONGS_TO, 'User', 'winner_user_id'),
			'work' => array(self::BELONGS_TO, 'ContestWork', 'winner_work_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'winner_id' => 'Winner',
			'winner_contest_id' => 'Winner Contest',
			'winner_place' => 'Winner Place',
			'winner_prize_id' => 'Winner Prize',
			'winner_user_id' => 'Winner User',
			'winner_work_id' => 'Winner Work',
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

		$criteria->compare('winner_id',$this->winner_id,true);
		$criteria->compare('winner_contest_id',$this->winner_contest_id,true);
		$criteria->compare('winner_place',$this->winner_place);
		$criteria->compare('winner_prize_id',$this->winner_prize_id,true);
		$criteria->compare('winner_user_id',$this->winner_user_id,true);
		$criteria->compare('winner_work_id',$this->winner_work_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}