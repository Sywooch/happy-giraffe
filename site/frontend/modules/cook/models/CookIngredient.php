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
 * @property string $checked
 *
 * The followings are the available model relations:
 * @property CookIngredientSynonym[] $synonyms
 * @property CookIngredientCategory $category
 * @property CookUnit $unit
 * @property CookUnit[] $availableUnits
 * @property CookIngredientNutritional[] $nutritionals
 */
class CookIngredient extends HActiveRecord
{
    public $other;

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
            array('checked', 'numerical', 'integerOnly' => true),
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
            'synonyms' => array(self::HAS_MANY, 'CookIngredientSynonym', 'ingredient_id'),
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
            'unit_id' => 'Единица измерения <span>(по умолчанию)</span>',
            'title' => 'Название',
            'density' => 'Плотность <span>(г/см3)</span>',
            'src' => 'Источник',
            'textSynonyms' => 'Синонимы',
            'textNutritional' => 'Состав продукта',
            'textUnits' => 'Единицы измерения'
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
        $criteria->compare('checked', $this->checked);


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
    public function findByNameWithCalories($term, $limit = 10)
    {
        $subquery = Yii::app()->db->createCommand()
            ->select('t.id')
            ->from($this->tableName() . ' as t')
            ->join(CookIngredientNutritional::model()->tableName(), CookIngredientNutritional::model()->tableName() . '.ingredient_id = t.id')
            ->where('cook__ingredients_nutritionals.nutritional_id = 1')
            ->text;

        $criteria = new CDbCriteria;
        $criteria->condition = 't.id IN (' . $subquery . ')';

        return $this->findByName($term, $limit, $criteria);
    }

    public function findByName($term, $limit = 10, $condition = '', $params = array())
    {
        $additionalCriteria = $this->getCommandBuilder()->createCriteria($condition, $params);
        $criteria = new CDbCriteria;
        $criteria->limit = $limit;
        $criteria->distinct = true;
        $criteria->mergeWith($additionalCriteria);
        $criteria->join = 'LEFT JOIN cook__ingredient_synonyms ON cook__ingredient_synonyms.ingredient_id = t.id';
        $criteria->order = 't.title ASC';
        $criteriaMore = clone $criteria;

        $criteria->compare('t.title', $term . '%', true, 'AND', false);
        $ingredients = $this->findAll($criteria);

        if (count($ingredients) < $limit) {
            $criteria->compare('cook__ingredient_synonyms.title', $term . '%', true, 'OR', false);
            $ingredientsMore = $this->findAll($criteriaMore);
            while (count($ingredients) < $limit && !empty($ingredientsMore)) {
                array_push($ingredients, $ingredientsMore[0]);
                array_shift($ingredientsMore);
            }

            if (count($ingredients) < $limit) {
                $criteriaMore->compare('t.title', $term, true, 'AND');
                $criteriaMore->compare('cook__ingredient_synonyms.title', $term, true, 'OR');
                $ingredientsMore = $this->findAll($criteriaMore);

                while (count($ingredients) < $limit && !empty($ingredientsMore)) {
                    array_push($ingredients, $ingredientsMore[0]);
                    array_shift($ingredientsMore);
                }
            }
        }

        return $ingredients;
    }

    public function autoComplete($term, $limit = 10, $withCalories = false, $withUnits = false, $condition = '')
    {
        $ingredients = ($withCalories) ? $this->findByNameWithCalories($term, $limit) : $this->findByName($term, $limit, $condition);

        $result = array();
        $ids = array();

        foreach ($ingredients as $ing) {
            if (in_array($ing->id, $ids))
                continue;
            $ids[] = $ing->id;

            $i = array(
                'value' => $ing->title,
                'label' => $ing->title,
                'id' => $ing->id,
                'unit_id' => $ing->unit_id,
                'density' => $ing->density,
                'unit' => $ing->unit->title
            );


            if ($withCalories) {
                foreach ($ing->nutritionals as $nutritional)
                    $i['nutritionals'][$nutritional->nutritional_id] = $nutritional->value;
            }
            if ($withUnits) {
                foreach ($ing->units as $unit)
                    $i['units'][$unit->unit_id] = $unit->weight;
                foreach ($ing->units as $unit)
                    $i['units_titles'][] = array('id' => $unit->unit_id, 'title' => $unit->unit->title);
            }
            $result[] = $i;
        }

        return $result;
    }

    public function getTextSynonyms()
    {
        $arr = array();
        foreach ($this->synonyms as $synonym) {
            $arr[] = $synonym->title;
        }

        return implode(',', $arr);
    }

    public function getTextNutritional()
    {
        $arr = array();
        foreach ($this->nutritionals as $model) {
            $arr[] = $model->nutritional->title . ': ' . (float)$model->value;
        }

        return implode('<br>', $arr);
    }

    public function getNutritional($id)
    {
        $cal = CookIngredientNutritional::model()->findByAttributes(array('nutritional_id' => $id, 'ingredient_id' => $this->id));
        return isset($cal) ? (float)$cal->value : '';
    }

    public function getTextUnits()
    {
        $arr = array();
        foreach ($this->availableUnits as $model) {
            $arr[] = $model->title;
        }

        return implode(', ', $arr);
    }
}