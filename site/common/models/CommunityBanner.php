<?php

/**
 * This is the model class for table "community__banners".
 *
 * The followings are the available columns in table 'community__banners':
 * @property string $id
 * @property string $content_id
 * @property string $photo_id
 * @property string $class
 * @property string $title
 *
 * The followings are the available model relations:
 * @property AlbumPhoto $photo
 * @property CommunityContent $content
 */
class CommunityBanner extends CActiveRecord
{
    public $colors = array(
        'green' => 'Зеленый',
        'blue' => 'Синий',
    );

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CommunityBanner the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'community__banners';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('content_id, class, title', 'required'),
            array('content_id, photo_id', 'length', 'max'=>11),
            array('class, title', 'length', 'max'=>255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, content_id, photo_id, class, title', 'safe', 'on'=>'search'),
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
            'photo' => array(self::BELONGS_TO, 'AlbumPhoto', 'photo_id'),
            'content' => array(self::BELONGS_TO, 'CommunityContent', 'content_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'content_id' => 'К посту',
            'photo_id' => 'Изображение',
            'class' => 'Цвет',
            'title' => 'Заголовок',
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
        $criteria->compare('content_id',$this->content_id,true);
        $criteria->compare('photo_id',$this->photo_id,true);
        $criteria->compare('class',$this->class,true);
        $criteria->compare('title',$this->title,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function getImage()
    {
        if (!empty($this->photo_id)) {
            return CHtml::image($this->photo->getPreviewUrl(70, 70));
        }

        return '';
    }
}