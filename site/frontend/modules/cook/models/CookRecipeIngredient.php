<?php

/**
 * This is the model class for table "cook__recipe_ingredients".
 *
 * The followings are the available columns in table 'cook__recipe_ingredients':
 * @property string $id
 * @property string $recipe_id
 * @property string $ingredient_id
 * @property string $unit_id
 * @property string $value
 *
 * The followings are the available model relations:
 * @property CookUnits $unit
 * @property CookRecipes $recipe
 * @property CookIngredients $ingredient
 */
class CookRecipeIngredient extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CookRecipeIngredient the static model class
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
		return 'cook__recipe_ingredients';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('recipe_id, ingredient_id, unit_id, value', 'required'),
            array('recipe_id', 'exist', 'attributeName' => 'id', 'className' => 'CookRecipe'),
            array('ingredient_id', 'exist', 'attributeName' => 'id', 'className' => 'CookIngredients'),
            array('unit_id', 'exist', 'attributeName' => 'id', 'className' => 'CookUnits'),
            array('value', 'numerical', 'min' => '0.01', 'max' => '9999.99'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, recipe_id, ingredient_id, unit_id, value', 'safe', 'on'=>'search'),
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
			'recipe' => array(self::BELONGS_TO, 'CookRecipe', 'recipe_id'),
			'ingredient' => array(self::BELONGS_TO, 'CookIngredient', 'ingredient_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'recipe_id' => 'Recipe',
			'ingredient_id' => 'Ingredient',
			'unit_id' => 'Unit',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('recipe_id',$this->recipe_id,true);
		$criteria->compare('ingredient_id',$this->ingredient_id,true);
		$criteria->compare('unit_id',$this->unit_id,true);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}