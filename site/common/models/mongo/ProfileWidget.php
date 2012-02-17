<?php

class ProfileWidget extends EMongoDocument
{
    public $title;
    public $description;
    public $class;

    private $_object = null;

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

    public function getObject()
    {
        if ($this->_object == null) {
            $this->_object = new $this->class;
        }

        return $this->_object;
    }
}