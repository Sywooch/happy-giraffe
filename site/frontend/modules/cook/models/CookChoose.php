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
 * @property string $slug
 * @property string $title_quality
 * @property string $title_defective
 * @property string $title_check
 *
 * The followings are the available model relations:
 * @property CookChooseCategories $category
 */
class CookChoose extends HActiveRecord implements IPreview
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
            array('category_id, title, title_accusative, title_quality, title_defective, title_check', 'required'),
            array('category_id', 'length', 'max' => 11),
            array('title, title_accusative, title_quality, title_defective, title_check', 'length', 'max' => 255),
            array('slug', 'site.frontend.extensions.translit.ETranslitFilter', 'translitAttribute' => 'title'),
            array('desc, desc_quality, desc_defective, desc_check, title_quality, title_defective, title_check', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, category_id, title, title_accusative, desc, desc_quality, desc_defective, desc_check, title_quality, title_defective, title_check', 'safe', 'on' => 'search'),
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
            'title_quality' => 'Как выглядит "качественный продукт"',
            'desc_quality' => 'Признаки качественного',
            'title_defective' => 'Как выглядит "некачественный продукт"',
            'desc_defective' => 'Признаки некачественного',
            'title_check' => 'Как проверить "качество продукта"',
            'desc_check' => 'Как можно проверить качество',
            'photo_id' => 'Фотография',
            'slug' => 'slug'
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
        $criteria->compare('title_quality', $this->desc, true);

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

    public function getRandomChooses($limit = 3)
    {
        $criteria = new CDbCriteria(array(
            'limit' => $limit,
            'order' => 'RAND()',
            'with' => 'photo',
        ));

        return $this->findAll($criteria);
    }

    public function getUrl()
    {
        return Yii::app()->controller->createUrl('/cook/choose/view', array('id' => $this->slug));
    }

    public function getPreviewPhoto()
    {
        return $this->photo->getPreviewUrl(70, 70);
    }

    public function getPreviewText()
    {
        return $this->desc_quality;
    }
}