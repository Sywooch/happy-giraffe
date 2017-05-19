<?php

namespace site\frontend\modules\iframe\modules\admin\models;

use site\frontend\modules\api\ApiModule;

class FramePartners extends \HActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'frame_partners';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('key', 'required'),
            array('type', 'length', 'max' => 11),
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
            'id' => 'ID',
            'type' => 'Тип',
            'description' => 'Описание',
            'key' => 'Ключ',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return FramePartners the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new \CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('type',$this->type,true);
        $criteria->compare('key',$this->key);

        return new \CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
            'pagination' => array('pageSize' => 100),
        ));
    }

    public function behaviors()
    {
        return array(
            'HTimestampBehavior' => array(
                'class' => 'HTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
            ),
            'CacheDelete' => [
                'class' => ApiModule::CACHE_DELETE,
            ],
        );
    }
}
