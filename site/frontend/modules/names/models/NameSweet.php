<?php

/**
 * This is the model class for table "name__sweets".
 *
 * The followings are the available columns in table 'name__sweets':
 * @property integer $id
 * @property string $name_id
 * @property string $value
 *
 * The followings are the available model relations:
 * @property Name $name
 */
class NameSweet extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return NameSweet the static model class
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
		return 'name__sweets';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name_id', 'required'),
			array('name_id', 'length', 'max'=>10),
			array('value', 'length', 'max'=>255),
            array('name_id+value', 'uniqueMultiColumnValidator'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name_id, value', 'safe', 'on'=>'search'),
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
			'name' => array(self::BELONGS_TO, 'Name', 'name_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name_id' => 'Name',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name_id',$this->name_id,true);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}