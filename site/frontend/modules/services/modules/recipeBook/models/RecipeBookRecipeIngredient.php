<?php

/**
 * This is the model class for table "recipe_book__recipes_ingredients".
 *
 * The followings are the available columns in table 'recipe_book__recipes_ingredients':
 * @property string $id
 * @property string $recipe_id
 * @property string $unit_id
 * @property string $ingredient_id
 * @property string $value
 * @property string $display_value
 *
 * The followings are the available model relations:
 * @property RecipeBookIngredients $ingredient
 * @property RecipeBookRecipes $recipe
 * @property RecipeBookUnits $unit
 */
class RecipeBookRecipeIngredient extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RecipeBookRecipeIngredient the static model class
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
		return 'recipe_book__recipes_ingredients';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('recipe_id, unit_id, ingredient_id, value, display_value', 'required'),
			array('recipe_id, unit_id, ingredient_id', 'length', 'max'=>11),
			array('value, display_value', 'length', 'max'=>6),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, recipe_id, unit_id, ingredient_id, value, display_value', 'safe', 'on'=>'search'),
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
			'ingredient' => array(self::BELONGS_TO, 'RecipeBookIngredients', 'ingredient_id'),
			'recipe' => array(self::BELONGS_TO, 'RecipeBookRecipes', 'recipe_id'),
			'unit' => array(self::BELONGS_TO, 'RecipeBookUnits', 'unit_id'),
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
			'unit_id' => 'Unit',
			'ingredient_id' => 'Ingredient',
			'value' => 'Value',
			'display_value' => 'Display Value',
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
		$criteria->compare('unit_id',$this->unit_id,true);
		$criteria->compare('ingredient_id',$this->ingredient_id,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('display_value',$this->display_value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}