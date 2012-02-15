<?php

class ProfileWidgetSetting extends EMongoDocument
{
    public $box_id;
    public $attribute_name;
    public $attribute_value;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'settings';
    }

    public function rules()
    {
        return array(
            array('box_id, attribute_id, attribute_value', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'box_id' => 'Ящик',
            'attribute_id' => 'Атрибут',
            'attribute_value' => 'Значение атрибута',
        );
    }


    public function getUserSettings($user_id)
    {
        $_settings = array();
        $settings = ProfileWidgetSetting::findAllByAttributes(array('user_id' => $user_id));
        foreach ($settings as $s)
        {
            $_settings[$s->box_id][$s->attribute_name] = $s->attribute_value;
        }
        return $_settings;
    }
}