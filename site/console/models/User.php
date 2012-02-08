<?php

class User extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return User the static model class
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
        return '{{user}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
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
        );
    }

    public function afterSave()
    {
        //Yii::app()->cache->delete('User_' . $this->id);
        $cacheKey='yii:dbquery'.Yii::app()->db->connectionString.':'.Yii::app()->db->username;
        $cacheKey.=':'.'SELECT * FROM `user` `t` WHERE `t`.`id`=\''.$this->id.'\' LIMIT 1:a:0:{}';
        Yii::app()->cache->delete($cacheKey);
    }
}