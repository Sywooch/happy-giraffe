<?php

/**
 * This is the model class for table "cook__recipe_tags".
 *
 * The followings are the available columns in table 'cook__recipe_tags':
 * @property string $id
 * @property string $title
 * @property string $description
 * @property string $text_title
 * @property string $text
 *
 * The followings are the available model relations:
 * @property CookRecipe[] $recipes
 */
class CookRecipeTag extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CookRecipeTag the static model class
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
        return 'cook__recipe_tags';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title', 'required'),
            array('title', 'length', 'max' => 255),
            array('description, text_title, text', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, description, text_title, text', 'safe', 'on'=>'search'),
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
            'recipes' => array(self::MANY_MANY, 'CookRecipe', 'cook__recipe_recipes_tags(tag_id, recipe_id)'),
            'recipesCount' => array(self::STAT, 'CookRecipe', 'cook__recipe_recipes_tags(tag_id, recipe_id)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Название',
            'description' => 'Верхний текст',
            'text_title' => 'Название притчи',
            'text' => 'Текст притчи',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id,true);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('description',$this->description,true);
        $criteria->compare('text_title',$this->text_title,true);
        $criteria->compare('text',$this->text,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination' => array('pageSize' => 150),
        ));
    }

    public function scopes()
    {
        return array(
            'alphabet' => array(
                'order' => 'title',
            )
        );
    }

    public function getUrl()
    {
        return Yii::app()->createUrl('/cook/recipe/tag', array('tag'=>$this->id));
    }

    public function beforeSave()
    {
        return false;
    }
}