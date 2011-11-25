<?php

/**
 * This is the model class for table "{{contest_map}}".
 *
 * The followings are the available columns in table '{{contest_map}}':
 * @property string $map_id
 * @property string $map_contest_id
 * @property integer $map_object
 * @property string $map_object_id
 *
 * rel
 * @property Contest $contest
 *
 */
class ContestMap extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ContestMap the static model class
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
		return '{{club_contest_map}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('map_object', 'numerical', 'integerOnly'=>true),
			array('map_contest_id, map_object_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('map_id, map_contest_id, map_object, map_object_id', 'safe', 'on'=>'search'),
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
			'contest' => array(self::BELONGS_TO, 'Contest', 'map_contest_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'map_id' => 'Map',
			'map_contest_id' => 'Map Contest',
			'map_object' => 'Map Object',
			'map_object_id' => 'Map Object',
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

		$criteria->compare('map_id',$this->map_id,true);
		$criteria->compare('map_contest_id',$this->map_contest_id,true);
		$criteria->compare('map_object',$this->map_object);
		$criteria->compare('map_object_id',$this->map_object_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}