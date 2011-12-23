<?php

/**
 * This is the model class for table "recipeBook_disease".
 *
 * The followings are the available columns in table 'recipeBook_disease':
 * @property string $id
 * @property string $name
 * @property string $category_id
 *
 * The followings are the available model relations:
 * @property RecipeBookDiseaseCategory $category
 * @property RecipeBookRecipe[] $recipeBookRecipes
 */
class RecipeBookDisease extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return RecipeBookDisease the static model class
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
		return 'recipeBook_disease';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, category_id', 'required'),
			array('name', 'length', 'max' => 255),
			array('category_id', 'exist', 'attributeName' => 'id', 'className' => 'RecipeBookDiseaseCategory'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, category_id', 'safe', 'on'=>'search'),
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
			'category' => array(self::BELONGS_TO, 'RecipeBookDiseaseCategory', 'category_id'),
			'recipes' => array(self::HAS_MANY, 'RecipeBookRecipe', 'disease_id'),
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
			'category_id' => 'Category',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('category_id',$this->category_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}