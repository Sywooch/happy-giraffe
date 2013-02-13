<?php

/**
 * This is the model class for table "valentine__videos".
 *
 * The followings are the available columns in table 'valentine__videos':
 * @property string $id
 * @property string $vimeo_id
 * @property string $title
 * @property string $photo_id
 *
 * The followings are the available model relations:
 * @property AlbumPhotos $photo
 */
class ValentineVideo extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ValentineVideo the static model class
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
        return 'valentine__videos';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('vimeo_id, title, photo_id', 'required'),
            array('vimeo_id, title', 'length', 'max'=>255),
            array('photo_id', 'length', 'max'=>11),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, vimeo_id, title, photo_id', 'safe', 'on'=>'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'vimeo_id' => 'Vimeo',
            'title' => 'Title',
            'photo_id' => 'Photo',
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
        $criteria->compare('vimeo_id',$this->vimeo_id,true);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('photo_id',$this->photo_id,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}