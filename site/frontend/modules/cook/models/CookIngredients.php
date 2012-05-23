<?php

/**
 * This is the model class for table "cook__ingredients".
 *
 * The followings are the available columns in table 'cook__ingredients':
 * @property string $id
 * @property string $category_id
 * @property string $unit_id
 * @property string $title
 * @property string $weight
 * @property string $density
 * @property string $src
 *
 * The followings are the available model relations:
 * @property CookIngredientSynonyms[] $cookIngredientSynonyms
 * @property CookIngredientsCategories $category
 * @property CookUnits $unit
 * @property CookIngredientsNutritionals[] $cookIngredientsNutritionals
 */
class CookIngredients extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CookIngredients the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cook__ingredients';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('category_id, title', 'required'),
            array('category_id, unit_id, weight', 'length', 'max' => 11),
            array('title, src', 'length', 'max' => 255),
            array('density', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, category_id, unit_id, title, weight, density', 'safe', 'on' => 'search'),
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
            'cookIngredientSynonyms' => array(self::HAS_MANY, 'CookIngredientSynonyms', 'ingredient_id'),
            'category' => array(self::BELONGS_TO, 'CookIngredientsCategories', 'category_id'),
            'unit' => array(self::BELONGS_TO, 'CookUnits', 'unit_id'),
            'cookIngredientsNutritionals' => array(self::HAS_MANY, 'CookIngredientsNutritionals', 'ingredient_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'category_id' => 'Категория',
            'unit_id' => 'Ед.изм.',
            'title' => 'Название',
            'weight' => 'Вес г',
            'density' => 'Плотность г/см³',
            'src' => 'Источник',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('category_id', $this->category_id, true);
        $criteria->compare('unit_id', $this->unit_id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('weight', $this->weight, true);
        $criteria->compare('density', $this->density, true);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => '25',
            ),
        ));
    }
}