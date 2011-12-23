<?php

/**
 * This is the model class for table "recipeBook_recipe".
 *
 * The followings are the available columns in table 'recipeBook_recipe':
 * @property string $id
 * @property string $name
 * @property string $disease_id
 * @property string $text
 *
 * The followings are the available model relations:
 * @property RecipeBookIngredient[] $recipeBookIngredients
 * @property RecipeBookDisease $disease
 * @property RecipeBookRecipeViaPurpose[] $recipeBookRecipeViaPurposes
 */
class RecipeBookRecipe extends CActiveRecord
{
	public $purposeIds = array();

	public function afterFind()
	{
		if (! empty($this->purposes))
		{
			foreach ($this->purposes as $n => $service)
			{
				$this->purposeIds[] = $service->id;
			}
		}

		parent::afterFind();
	}

	public function setPurposeIds($value)
	{
		$this->purposeIds = $value;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @return RecipeBookRecipe the static model class
	 */	 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function behaviors()
	{
		return array('CAdvancedArBehavior' => array('class' => 'application.extensions.CAdvancedArBehavior'));
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'recipeBook_recipe';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, disease_id, text', 'required'),
			array('name', 'length', 'max'=>255),
			array('disease_id', 'exist', 'attributeName' => 'id', 'className' => 'RecipeBookDisease'),
			array('purposeIds', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, disease_id, text', 'safe', 'on'=>'search'),
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
			'ingredients' => array(self::HAS_MANY, 'RecipeBookIngredient', 'recipe_id'),
			'disease' => array(self::BELONGS_TO, 'RecipeBookDisease', 'disease_id'),
			'purposes' => array(self::MANY_MANY, 'RecipeBookPurpose', 'recipeBook_recipe_via_purpose(recipe_id, purpose_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Заголовок рецепта',
			'disease_id' => 'Болезнь',
			'text' => 'Текст рецепта',
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
		$criteria->compare('disease_id',$this->disease_id,true);
		$criteria->compare('text',$this->text,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}