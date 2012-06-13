<?php

/**
 * This is the model class for table "cook__choose".
 *
 * The followings are the available columns in table 'cook__choose':
 * @property string $id
 * @property string $category_id
 * @property string $title
 * @property string $title_accusative
 * @property string $desc
 * @property string $desc_quality
 * @property string $desc_defective
 * @property string $desc_check
 * @property string $photo_id
 *
 * The followings are the available model relations:
 * @property CookChooseCategories $category
 */
class CookChoose extends HActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cook__choose';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('category_id, title, title_accusative', 'required'),
            array('category_id', 'length', 'max' => 11),
            array('title, title_accusative', 'length', 'max' => 255),
            array('desc, desc_quality, desc_defective, desc_check', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, category_id, title, title_accusative, desc, desc_quality, desc_defective, desc_check', 'safe', 'on' => 'search'),
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
            'category' => array(self::BELONGS_TO, 'CookChooseCategory', 'category_id'),
            'photo' => array(self::BELONGS_TO, 'AlbumPhoto', 'photo_id')
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
            'title' => 'Продукт',
            'title_accusative' => 'Продукт винительный падеж',
            'desc' => 'О продукте',
            'desc_quality' => 'Признаки качественного',
            'desc_defective' => 'Признаки некачественного',
            'desc_check' => 'Как можно проверить качество',
            'photo_id' => 'Фотография'
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
        $criteria->compare('category_id', $this->category_id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('title_accusative', $this->title_accusative, true);
        $criteria->compare('desc', $this->desc, true);
        $criteria->compare('desc_quality', $this->desc_quality, true);
        $criteria->compare('desc_defective', $this->desc_defective, true);
        $criteria->compare('desc_check', $this->desc_check, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getImage()
    {
        if (!empty($this->photo_id))
            return CHtml::image($this->photo->getPreviewUrl(70, 70));
        return '';
    }
}