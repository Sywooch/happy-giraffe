<?php

class ProfileWidget extends EMongoDocument
{
    public $title;
    public $class_name;
    public $description;

    public function getCollectionName()
    {
        return 'profileWidgets';
    }

    public function rules()
    {
        return array(
            array('title, name, description', 'required'),
        );
    }

    public function attributeNames()
    {
        return array(
            'title' => 'Заголовок',
            'class_name' => 'Класс',
            'description' => 'Описание',
        );
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}