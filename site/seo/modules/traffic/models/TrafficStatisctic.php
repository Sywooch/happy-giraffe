<?php

/**
 * This is the model class for table "traffic__statisctics".
 *
 * The followings are the available columns in table 'traffic__statisctics':
 * @property string $section_id
 * @property string $date
 * @property integer $value
 *
 * The followings are the available model relations:
 * @property TrafficSection $section
 */
class TrafficStatisctic extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TrafficStatisctic the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return CDbConnection database connection
	 */
	public function getDbConnection()
	{
		return Yii::app()->db_seo;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'traffic__statisctics';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('section_id, date, value', 'required'),
			array('value', 'numerical', 'integerOnly'=>true),
			array('section_id', 'length', 'max'=>10),
            array('section_id+date', 'uniqueMultiColumnValidator'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('section_id, date, value', 'safe', 'on'=>'search'),
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
			'section' => array(self::BELONGS_TO, 'TrafficSection', 'section_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'section_id' => 'Section',
			'date' => 'Date',
			'value' => 'Value',
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

		$criteria->compare('section_id',$this->section_id,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('value',$this->value);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}