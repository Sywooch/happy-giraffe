<?php

/**
 * This is the model class for table "cook__ingredients_nutritionals".
 *
 * The followings are the available columns in table 'cook__ingredients_nutritionals':
 * @property string $id
 * @property string $ingredient_id
 * @property string $nutritional_id
 * @property string $value
 *
 * The followings are the available model relations:
 * @property CookNutritionals $nutritional
 * @property CookIngredient $ingredient
 */
class CookIngredientsNutritionals extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CookIngredientsNutritionals the static model class
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
		return 'cook__ingredients_nutritionals';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ingredient_id, nutritional_id, value', 'required'),
			array('ingredient_id, nutritional_id', 'length', 'max'=>11),
            array('ingredient_id, nutritional_id, value', 'numerical', 'allowEmpty'=>false),
			array('value', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ingredient_id, nutritional_id, value', 'safe', 'on'=>'search'),
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
			'nutritional' => array(self::BELONGS_TO, 'CookNutritionals', 'nutritional_id'),
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
			'ingredient_id' => 'Ингредиент',
			'nutritional_id' => 'Составляющая',
			'value' => 'Значение',
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
		$criteria->compare('nutritional_id',$this->nutritional_id,true);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}