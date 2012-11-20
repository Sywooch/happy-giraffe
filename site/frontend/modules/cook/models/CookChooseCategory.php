<?php

/**
 * This is the model class for table "cook__choose__categories".
 *
 * The followings are the available columns in table 'cook__choose__categories':
 * @property string $id
 * @property string $title
 * @property string $description
 * @property string $description_center
 * @property string $description_extra
 * @property string $photo_id
 * @property string $slug
 *
 * The followings are the available model relations:
 * @property CookChoose[] $cookChooses
 */
class CookChooseCategory extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CookChooseCategory the static model class
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
        return 'cook__choose__categories';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, photo_id, title_accusative', 'required'),
            array('title, title_accusative', 'length', 'max' => 255),
            array('photo_id', 'length', 'max' => 11),
            array('description, description_extra, description_center', 'safe'),
            array('slug', 'site.frontend.extensions.translit.ETranslitFilter', 'translitAttribute' => 'title'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, title_accusative, description, description_extra, photo_id', 'safe', 'on' => 'search'),
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
            'chooses' => array(self::HAS_MANY, 'CookChoose', 'category_id',
                'order' => 'chooses.title',
            ),
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
            'title' => 'Заголовок',
            'title_accusative' => 'Как выбрать ...',
            'description' => 'Описание (курсив не нужен)',
            'description_center'=>'Описание под фото',
            'description_extra' => 'Описание снизу',
            'photo_id' => 'Фото',
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
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('description_extra', $this->description_extra, true);
        $criteria->compare('photo_id', $this->photo_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => '25',
            ),
        ));
    }

    public function getImage()
    {
        if (!empty($this->photo_id))
            return CHtml::image($this->photo->getPreviewUrl(70, 70));
        return '';
    }

    public function getUrl()
    {
        return Yii::app()->controller->createUrl('/cook/choose/view', array('id' => $this->slug));
    }
}