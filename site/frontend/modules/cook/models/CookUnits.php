<?php

class CookUnits extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CookUnits the static model class
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
		return 'cook__units';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, type, ratio', 'required'),
			array('parent_id', 'length', 'max'=>11),
			array('title, title2, title3, type', 'length', 'max'=>255),
			array('ratio', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, parent_id, title, title2, title3, type, ratio', 'safe', 'on'=>'search'),
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
			'cookIngredients' => array(self::HAS_MANY, 'CookIngredients', 'default_unit_id'),
			'parent' => array(self::BELONGS_TO, 'CookUnits', 'parent_id'),
			'cookUnits' => array(self::HAS_MANY, 'CookUnits', 'parent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parent_id' => 'Parent',
			'title' => 'Title',
			'title2' => 'Title2',
			'title3' => 'Title3',
			'type' => 'Type',
			'ratio' => 'Ratio',
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
		$criteria->compare('parent_id',$this->parent_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('title2',$this->title2,true);
		$criteria->compare('title3',$this->title3,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('ratio',$this->ratio,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


}