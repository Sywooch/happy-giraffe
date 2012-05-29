<?php

/**
 * This is the model class for table "cook__spices".
 *
 * The followings are the available columns in table 'cook__spices':
 * @property string $id
 * @property string $ingredient_id
 * @property string $title
 * @property string $content
 * @property string $photo
 *
 * The followings are the available model relations:
 * @property CookIngredients $ingredient
 * @property CookSpicesCategoriesSpices[] $cookSpicesCategoriesSpices
 * @property CookSpicesHints[] $cookSpicesHints
 */
class CookSpices extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CookSpices the static model class
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
        return 'cook__spices';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ingredient_id, title', 'required'),
            array('ingredient_id', 'length', 'max' => 11),
            array('title, photo', 'length', 'max' => 255),
            array('content', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, ingredient_id, title, content, photo', 'safe', 'on' => 'search'),
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
            'ingredient' => array(self::BELONGS_TO, 'CookIngredients', 'ingredient_id'),
            //'cookSpicesCategoriesSpices' => array(self::HAS_MANY, 'CookSpicesCategoriesSpices', 'spice_id'),
            'categories' => array(self::MANY_MANY, 'CookSpicesCategories', 'cook__spices__categories_spices(spice_id, category_id)'),
            'hints' => array(self::HAS_MANY, 'CookSpicesHints', 'spice_id'),
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
            'title' => 'Заголовок',
            'content' => 'Описание',
            'photo' => 'Фотография',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('ingredient_id', $this->ingredient_id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('photo', $this->photo, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function behaviors()
    {
        return array(
            'ManyToManyBehavior'
        );
    }

    public function getCategories()
    {
        $result = array();
        foreach ($this->categories as $category) {
            $result[] = $category->id;
        }
        return $result;
    }
}