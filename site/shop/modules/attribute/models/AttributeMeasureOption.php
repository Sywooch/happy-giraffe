<?php

/**
 * This is the model class for table "shop__product_attribute_measure_option".
 *
 * The followings are the available columns in table 'shop__product_attribute_measure_option':
 * @property integer $id
 * @property integer $measure_id
 * @property string $title
 *
 * The followings are the available model relations:
 * @property AttributeMeasure $measure
 */
class AttributeMeasureOption extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return AttributeMeasureOption the static model class
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
		return 'shop__product_attribute_measure_option';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('measure_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>256),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, measure_id, title', 'safe', 'on'=>'search'),
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
			'measure' => array(self::BELONGS_TO, 'AttributeMeasure', 'measure_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'measure_id' => 'Measure',
			'title' => 'Title',
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
		$criteria->compare('measure_id',$this->measure_id);
		$criteria->compare('title',$this->title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}