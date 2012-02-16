<?php

class ProfileWidget extends EMongoDocument
{
    public $title;
    public $description;
    public $class;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'widgets';
    }

    public function rules()
    {
        return array(
            array('title, description, class', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'title' => 'Заголовок',
            'description' => 'Описание',
            'class' => 'Класс',
        );
    }
}