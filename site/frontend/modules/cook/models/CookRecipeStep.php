<?php

/**
 * This is the model class for table "cook__recipe_steps".
 *
 * The followings are the available columns in table 'cook__recipe_steps':
 * @property string $id
 * @property string $recipe_id
 * @property string $photo_id
 * @property string $text
 *
 * The followings are the available model relations:
 * @property CookRecipes $recipe
 * @property AlbumPhotos $photo
 */
class CookRecipeStep extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CookRecipeStep the static model class
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
		return 'cook__recipe_steps';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('recipe_id, text', 'required'),
			array('recipe_id', 'exist', 'attributeName' => 'id', 'className' => 'CookRecipe'),
            array('photo_id', 'exist', 'attributeName' => 'id', 'className' => 'AlbumPhoto'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, recipe_id, photo_id, text', 'safe', 'on'=>'search'),
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
			'recipe' => array(self::BELONGS_TO, 'CookRecipe', 'recipe_id'),
			'photo' => array(self::BELONGS_TO, 'AlbumPhoto', 'photo_id'),
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
			'photo_id' => 'Photo',
			'text' => 'Text',
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
		$criteria->compare('photo_id',$this->photo_id,true);
		$criteria->compare('text',$this->text,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}