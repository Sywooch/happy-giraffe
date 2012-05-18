<?php

/**
 * This is the model class for table "humor".
 *
 * The followings are the available columns in table 'humor':
 * @property string $id
 * @property string $photo_id
 * @property string $votes_rofl
 * @property string $votes_lol
 * @property string $votes_sad
 */
class Humor extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Humor the static model class
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
		return 'humor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('photo_id, votes_rofl, votes_lol, votes_sad', 'required'),
			array('photo_id, votes_rofl, votes_lol, votes_sad', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, photo_id, votes_rofl, votes_lol, votes_sad', 'safe', 'on'=>'search'),
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
			'photo_id' => 'Photo',
			'votes_rofl' => 'Votes Rofl',
			'votes_lol' => 'Votes Lol',
			'votes_sad' => 'Votes Sad',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('photo_id',$this->photo_id,true);
		$criteria->compare('votes_rofl',$this->votes_rofl,true);
		$criteria->compare('votes_lol',$this->votes_lol,true);
		$criteria->compare('votes_sad',$this->votes_sad,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}