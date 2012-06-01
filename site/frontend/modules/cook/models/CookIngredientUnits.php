<?php

/**
 * This is the model class for table "cook__ingredient_units".
 *
 * The followings are the available columns in table 'cook__ingredient_units':
 * @property string $id
 * @property string $ingredient_id
 * @property string $unit_id
 * @property integer $weight
 *
 * The followings are the available model relations:
 * @property CookUnit $unit
 * @property CookIngredients $ingredient
 */
class CookIngredientUnits extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CookIngredientUnits the static model class
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
		return 'cook__ingredient_units';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ingredient_id, unit_id', 'required'),
			array('weight', 'numerical', 'integerOnly'=>true),
			array('ingredient_id, unit_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ingredient_id, unit_id, weight', 'safe', 'on'=>'search'),
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
			'unit' => array(self::BELONGS_TO, 'CookUnit', 'unit_id'),
			'ingredient' => array(self::BELONGS_TO, 'CookIngredients', 'ingredient_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ingredient_id' => 'Ingredient',
			'unit_id' => 'Unit',
			'weight' => 'Weight',
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
		$criteria->compare('ingredient_id',$this->ingredient_id,true);
		$criteria->compare('unit_id',$this->unit_id,true);
		$criteria->compare('weight',$this->weight);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}