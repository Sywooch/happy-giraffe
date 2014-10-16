<?php

namespace site\frontend\modules\posts\models;

/**
 * This is the model class for table "post__tags".
 *
 * The followings are the available columns in table 'post__tags':
 * @property string $contentId
 * @property string $labelId
 */
class Tag extends \CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'post__tags';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('contentId, labelId', 'required'),
            array('contentId', 'length', 'max' => 10),
            array('labelId', 'length', 'max' => 20),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'contentId' => 'Content',
            'labelId' => 'Label',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PostTags the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}
