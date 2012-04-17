<?php

class WallpapersAreaForm extends CFormModel
{
    public $height;
    public $width;
    public $title;

    public function rules()
    {
        return array(
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
            'title' => 'Название'
        );
    }

    public function normalizeLength($attribute, $params)
    {
        $this->$attribute = trim(str_replace(',', '.', $this->$attribute));
        $this->$attribute = preg_replace('#[^0-9\.]+#', '', $this->$attribute);
    }


}