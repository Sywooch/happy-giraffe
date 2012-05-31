<?php

/**
 * This is the model class for table "cook__recipes".
 *
 * The followings are the available columns in table 'cook__recipes':
 * @property string $id
 * @property string $title
 * @property string $photo_id
 * @property integer $preparation_duration
 * @property integer $cooking_duration
 * @property integer $servings
 * @property string $advice
 * @property string $text
 * @property string $cuisine_id
 * @property integer $type
 * @property integer $method
 *
 * The followings are the available model relations:
 * @property CookRecipeIngredients[] $cookRecipeIngredients
 * @property CookRecipeSteps[] $cookRecipeSteps
 * @property AlbumPhotos $photo
 * @property CookCuisines $cuisine
 */
class CookRecipe extends CActiveRecord
{
    public $types = array(
        1 => 'Первые блюда',
        2 => 'Вторые блюда',
        3 => 'Салаты',
        4 => 'Закуски и бутерброды',
        5 => 'Сладкая выпечка',
        6 => 'Несладкая выпечка',
        7 => 'Торты и пирожные',
        8 => 'Десерты',
        9 => 'Напитки',
        10 => 'Соусы и кремы',
        11 => 'Консервация',
    );

    public $methods = array(
        1 => 'Варка',
        2 => 'Жарение',
        3 => 'Запекание',
        4 => 'Тушение',
        5 => 'Копчение',
        6 => 'Вяление',
        7 => 'Маринование',
        8 => 'Соление',
        9 => 'Квашение',
        10 => 'Сушение',
        11 => 'Замораживание',
        12 => 'Выпекание',
        13 => 'На углях',
    );

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CookRecipe the static model class
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
		return 'cook__recipes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, type, method', 'required'),
			array('title', 'length', 'max' => 255),
            array('photo_id', 'exist', 'attributeName' => 'id', 'className' => 'AlbumPhoto'),
            array('cuisine_id', 'exist', 'attributeName' => 'id', 'className' => 'CookCuisine'),
            array('servings', 'numerical', 'integerOnly' => true, 'min' => 1, 'max' => 10),
            array('type', 'in', 'range' => array_keys($this->types)),
            array('method', 'in', 'range' => array_keys($this->methods)),
            array('preparation_duration, cooking_duration', 'numerical', 'integerOnly' => true, 'min' => 1, 'max' => 999),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, photo_id, preparation_duration, cooking_duration, servings, advice, text, cuisine_id, type, method', 'safe', 'on'=>'search'),
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
            'ingredients' => array(self::HAS_MANY, 'CookRecipeIngredient', 'recipe_id'),
            'steps' => array(self::HAS_MANY, 'CookRecipeStep', 'recipe_id'),
            'photo' => array(self::BELONGS_TO, 'AlbumPhoto', 'photo_id'),
            'cuisine' => array(self::BELONGS_TO, 'CookCuisine', 'cuisine_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'photo_id' => 'Photo',
			'preparation_duration' => 'Preparation Duration',
			'cooking_duration' => 'Cooking Duration',
			'servings' => 'Servings',
			'advice' => 'Advice',
			'text' => 'Text',
			'cuisine_id' => 'Cuisine',
			'type' => 'Type',
			'method' => 'Method',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('photo_id',$this->photo_id,true);
		$criteria->compare('preparation_duration',$this->preparation_duration);
		$criteria->compare('cooking_duration',$this->cooking_duration);
		$criteria->compare('servings',$this->servings);
		$criteria->compare('advice',$this->advice,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('cuisine_id',$this->cuisine_id,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('method',$this->method);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}