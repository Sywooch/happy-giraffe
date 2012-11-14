<?php

/**
 * This is the model class for table "cook__spices__categories".
 *
 * The followings are the available columns in table 'cook__spices__categories':
 * @property string $id
 * @property string $title
 * @property string $content
 * @property string $photo_id
 * @property string $slug
 *
 * The followings are the available model relations:
 * @property CookSpicesCategoriesSpices[] $cookSpicesCategoriesSpices
 */
class CookSpiceCategory extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CookSpiceCategory the static model class
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
        return 'cook__spices__categories';
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
            array('title, slug', 'length', 'max' => 255),
            array('photo_id', 'numerical', 'integerOnly' => true),
            array('slug', 'site.frontend.extensions.translit.ETranslitFilter', 'translitAttribute' => 'title'),
            array('content', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, content', 'safe', 'on' => 'search'),
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
            //'cookSpicesCategoriesSpices' => array(self::HAS_MANY, 'CookSpicesCategoriesSpices', 'category_id'),
            'spices' => array(self::MANY_MANY, 'CookSpice', 'cook__spices__categories_spices(category_id, spice_id)', 'order'=>'t.title'),
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
            'title' => 'Название',
            'content' => 'Описание',
            'photo_id' => 'Фото',
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
        $criteria->compare('title', $this->title, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('photo_id', $this->photo_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 100)
        ));
    }

    public function getCategories()
    {
        return $ingredients = Yii::app()->db->createCommand()->select('*')->from($this->tableName())->queryAll();
    }

    public function getImage()
    {
        if (!empty($this->photo_id)) {
            return CHtml::image($this->photo->getPreviewUrl(70, 70));
        }

        return '';
    }

    public function getUrl()
    {
        return Yii::app()->controller->createUrl('/cook/spices/view', array('id' => $this->slug));
    }
}