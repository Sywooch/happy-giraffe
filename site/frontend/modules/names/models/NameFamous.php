<?php

Yii::import('site.frontend.extensions.ufile.UFiles', true);
Yii::import('site.frontend.extensions.ufile.UFileBehavior');
Yii::import('site.frontend.extensions.geturl.EGetUrlBehavior');
Yii::import('site.frontend.extensions.status.EStatusBehavior');

/**
 * This is the model class for table "name__famous".
 *
 * The followings are the available columns in table 'name__famous':
 * @property string $id
 * @property string $name_id
 * @property string $middle_name
 * @property string $last_name
 * @property string $description
 * @property string $photo
 * @property string $link
 *
 * The followings are the available model relations:
 * @property Name $name
 */
class NameFamous extends HActiveRecord
{
    public $image;
    public $accusativeName = 'Известную личность';

    /**
     * Returns the static model of the specified AR class.
     * @return NameFamous the static model class
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
        return 'name__famous';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name_id, last_name', 'required'),
            array('name_id', 'length', 'max' => 10),
            array('middle_name, last_name', 'length', 'max' => 50),
            array('description, photo', 'length', 'max' => 256),
            array('link', 'length', 'max' => 1024),
            array('link', 'url'),
            array('image', 'file', 'types' => 'jpg, gif, png', 'maxSize' => 1048576, 'allowEmpty' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name_id, middle_name, last_name, description, photo, link', 'safe', 'on' => 'search'),
            array('photo', 'unsafe'),
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
            'name' => array(self::BELONGS_TO, 'Name', 'name_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name_id' => 'Имя',
            'middle_name' => 'Отчество',
            'last_name' => 'Фамилия',
            'description' => 'Чем знаменит',
            'photo' => 'Фото',
            'link' => 'Ссылка'
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
        $criteria->compare('name.name', $this->name_id, true);
        $criteria->compare('middle_name', $this->middle_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('photo', $this->photo, true);

        $criteria->with = 'name';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function uploadTo()
    {
        return 'upload/names/famous/';
    }

    public function GetUrl()
    {
        return Yii::app()->params['frontend_url'] . $this->uploadTo() . $this->photo;
    }

    /**
     * Save good images
     */
    public function SaveImage()
    {
        Yii::import('site.frontend.extensions.image.Image');
        $temp_path = Yii::getPathOfAlias('site.frontend.www.temp_upload');
        $path = Yii::getPathOfAlias('site.frontend.www') . '/' . $this->uploadTo();
        $image = new Image($temp_path . '/' . $this->photo);
        $image->resize(200, 200, Image::AUTO);
        $ext = pathinfo($this->photo, PATHINFO_EXTENSION);

        $name = $this->id . '_' . substr(md5(microtime()), 0, 5) . '.' . $ext;
        while (file_exists($path . $name))
            $name = $this->id . '_' . substr(md5(microtime()), 0, 5) . '.' . $ext;

        $image->save($path . $name);
        $this->photo = $name;
    }

    protected function afterDelete()
    {
        $this->DeletePhoto();

        return parent::afterDelete();
    }

    public function DeletePhoto()
    {
        if (!empty($this->photo)) {
            if (file_exists($this->uploadTo() . $this->photo))
                unlink($this->uploadTo() . $this->photo);
        }
    }
}