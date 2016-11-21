<?php

/**
 * This is the model class for table "community__contest_winners".
 *
 * The followings are the available columns in table 'community__contest_winners':
 * @property string $contest_id
 * @property string $work_id
 * @property integer $place
 */
class CommunityContestWinner extends HActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'community__contest_winners';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('contest_id, work_id, place', 'required'),
			array('place', 'numerical', 'integerOnly'=>true),
			array('contest_id, work_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('contest_id, work_id, place', 'safe', 'on'=>'search'),
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
            'contest' => array(self::BELONGS_TO, 'CommunityContest', 'contest_id'),
            'work' => array(self::BELONGS_TO, 'CommunityContestWork', 'work_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'contest_id' => 'Contest',
			'work_id' => 'Work',
			'place' => 'Place',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('contest_id',$this->contest_id,true);
		$criteria->compare('work_id',$this->work_id,true);
		$criteria->compare('place',$this->place);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CommunityContestWinner the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
