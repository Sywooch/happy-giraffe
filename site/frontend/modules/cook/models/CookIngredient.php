<?php

/**
 * This is the model class for table "cook__ingredients".
 *
 * The followings are the available columns in table 'cook__ingredients':
 * @property string $id
 * @property string $category_id
 * @property string $unit_id
 * @property string $title
 * @property string $density
 * @property string $src
 *
 * The followings are the available model relations:
 * @property CookIngredientSynonyms[] $cookIngredientSynonyms
 * @property CookIngredientCategory $category
 * @property CookUnit $unit
 * @property CookIngredientsNutritionals[] $nutritionals
 */
class CookIngredient extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CookIngredient the static model class
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
            array('category_id, unit_id', 'length', 'max' => 11),
            array('title, src', 'length', 'max' => 255),
            array('density', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, category_id, unit_id, title, density', 'safe', 'on' => 'search'),
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
            'cookIngredientSynonyms' => array(self::HAS_MANY, 'CookIngredientSynonym', 'ingredient_id'),
            'units' => array(self::HAS_MANY, 'CookIngredientUnit', 'ingredient_id'),
            'category' => array(self::BELONGS_TO, 'CookIngredientCategory', 'category_id'),
            'unit' => array(self::BELONGS_TO, 'CookUnit', 'unit_id'),
            'nutritionals' => array(self::HAS_MANY, 'CookIngredientNutritional', 'ingredient_id'),
            'availableUnits' => array(self::MANY_MANY, 'CookUnit', 'cook__ingredient_units(ingredient_id, unit_id)'),
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
            'unit_id' => 'Ед.изм. по умолчанию',
            'title' => 'Название',
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
        $criteria->compare('density', $this->density, true);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => '25',
            ),
        ));
    }

    public function getUnitsIds()
    {
        return Yii::app()->db->createCommand()->select('unit_id')->from('cook__ingredient_units')
            ->where('ingredient_id = :id', array(':id' => $this->id))
            ->limit(100)->queryColumn();
    }

    public function getUnits()
    {
        $result = array();

        $temp = Yii::app()->db->createCommand()->select('*')->from('cook__ingredient_units')
            ->where('ingredient_id = :id', array(':id' => $this->id))
            ->limit(100)->queryAll();

        foreach ($temp as $t)
            $result[$t['unit_id']] = $t;

        return $result;
    }

    /**
     * @param string $term
     * @return CookIngredient[]
     */
    public function findByNameWithCalories($term)
    {
        //get all with calories
        $subquery = Yii::app()->db->createCommand()
            ->select('t.id')
            ->from($this->tableName() . ' as t')
            ->join(CookIngredientNutritional::model()->tableName(), CookIngredientNutritional::model()->tableName() . '.ingredient_id = t.id')
            ->where('cook__ingredients_nutritionals.nutritional_id = 1')
            ->text;

        $criteria = new CDbCriteria;
        $criteria->with = array('nutritionals');
        $criteria->together = true;
        $criteria->limit = 10;
        $criteria->condition = 't.id IN (' . $subquery . ')';

        $criteria2 = clone $criteria;
        $criteria2->compare('title', $term . '%', true, 'AND', false);
        $ingredients = CookIngredient::model()->findAll($criteria2);

        if (count($ingredients) < 10) {
            $criteria->compare('title', ' ' . $term, true, 'AND', true);
            $more_ingredients = CookIngredient::model()->findAll($criteria);

            while (count($ingredients) < 10 && !empty($more_ingredients)) {
                array_push($ingredients, $more_ingredients[0]);
                array_shift($more_ingredients);
            }
        }

        return $ingredients;
    }

    public function findByName($term, $condition = '', $params = array())
    {
        $additionalCriteria = $this->getCommandBuilder()->createCriteria($condition,$params);
        $criteria = new CDbCriteria;
        $criteria->limit = 10;
        $criteria->mergeWith($additionalCriteria);
        $criteriaMore = clone $criteria;

        $criteria->compare('t.title', $term . '%', true, 'AND', false);
        $ingredients = $this->findAll($criteria);

        if (count($ingredients) < 10) {
            $criteriaMore->compare('t.title', ' ' . $term, true, 'AND');
            $ingredientsMore = $this->findAll($criteriaMore);

            while (count($ingredients) < 10 && ! empty($ingredientsMore)) {
                array_push($ingredients, $ingredientsMore[0]);
                array_shift($ingredientsMore);
            }
        }

        return $ingredients;
    }
}