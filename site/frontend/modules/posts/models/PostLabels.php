<?php

namespace site\frontend\modules\posts\models;

/**
 * This is the model class for table "post__labels".
 *
 * The followings are the available columns in table 'post__labels':
 * @property string $id
 * @property string $text
 *
 * The followings are the available model relations:
 * @property PostContents[] $postContents
 */
class PostLabels extends \CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'post__labels';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('text', 'required'),
            array('text', 'length', 'max' => 20),
            array('id, text', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'postContents' => array(self::MANY_MANY, '\site\frontend\modules\posts\models\PostContents', 'post__tags(labelId, contentId)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'text' => 'Text',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('text', $this->text, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PostLabels the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}
