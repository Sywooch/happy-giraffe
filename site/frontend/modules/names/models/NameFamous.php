<?php

/**
 * This is the model class for table "name_famous".
 *
 * The followings are the available columns in table 'name_famous':
 * @property string $id
 * @property string $name_id
 * @property string $middle_name
 * @property string $last_name
 * @property string $description
 * @property string $photo
 *
 * The followings are the available model relations:
 * @property Name $name
 */
class NameFamous extends CActiveRecord
{
    public $image;

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
        return 'name_famous';
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
            array('image', 'file', 'types' => 'jpg, gif, png', 'maxSize' => 1048576, 'allowEmpty' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name_id, middle_name, last_name, description, photo', 'safe', 'on' => 'search'),
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

    public function GetAdminPhoto()
    {
        echo  CHtml::image('/'.$this->uploadTo() . $this->photo);
    }

    /**
     * Save good images
     */
    public function SaveImage()
    {
        $imagePath = $this->uploadTo();
        $file = $this->image;
        $name = $this->id . '_' . substr(md5(microtime()), 0, 5) . '.' . $file->extensionName;
        while (file_exists($imagePath . $name))
            $name = $this->id . '_' . substr(md5(microtime()), 0, 5) . '.' . $file->extensionName;

        if (!empty($file)) {
            $file->saveAs($imagePath . $name);
            Yii::import('ext.image.Image');
            $image = new Image($imagePath . $name);
            $image->resize(200, 200, Image::AUTO);
            $image->save($imagePath . $name);
        }
        $this->photo = $name;
        $this->save();
    }

    protected function afterDelete()
    {
        if (!empty($this->photo))
            unlink($this->uploadTo() . $this->photo);

        return parent::afterDelete();
    }
}