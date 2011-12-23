<?php

/**
 * This is the model class for table "recipeBook_ingredient".
 *
 * The followings are the available columns in table 'recipeBook_ingredient':
 * @property string $id
 * @property integer $name
 * @property integer $amount
 * @property string $unit
 * @property string $recipe_id
 *
 * The followings are the available model relations:
 * @property RecipeBookRecipe $recipe
 */
class RecipeBookIngredient extends CActiveRecord
{
	public static function getUnitValues()
	{
		return array(
			'g' => 'гр',
			'ml' => 'мл',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @return RecipeBookIngredient the static model class
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
		return 'recipeBook_ingredient';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, amount, unit', 'required'),
			array('name', 'length', 'max' => 255),
			array('amount', 'numerical', 'min' => 0.01, 'max' => 999.99),
			array('unit', 'in', 'range' => array_keys(self::getUnitValues())),
			array('recipe_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, amount, unit, recipe_id', 'safe', 'on'=>'search'),
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
			'recipe' => array(self::BELONGS_TO, 'RecipeBookRecipe', 'recipe_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'amount' => 'Amount',
			'unit' => 'Unit',
			'recipe_id' => 'Recipe',
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
		$criteria->compare('name',$this->name);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('unit',$this->unit,true);
		$criteria->compare('recipe_id',$this->recipe_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}