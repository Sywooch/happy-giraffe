<?php

class WallpapersAreaForm extends HFormModel
{
    public $height;
    public $width;
    public $title;
    public $qty;

    public function rules()
    {
        return array(
            array('qty', 'default', 'value' => 1),
            array('qty', 'numerical', 'integerOnly' => true),
            array('height', 'required', 'message' => 'Укажите высоту необклеиваемой области'),
            array('width', 'required', 'message' => 'Укажите ширину необклеиваемой области'),
            array('title', 'required', 'message' => 'Укажите название необклеиваемой области'),
            array('height, width', 'normalizeLength'),
            array('height, width', 'numerical', 'message' => 'Введите число')
        );
    }

    public function attributeLabels()
    {
        return array(
            'height' => 'Высота',
            'width' => 'Ширина',
            'title' => 'Название',
            'qty' => 'Количество'
        );
    }

}