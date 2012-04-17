<?php

class WallpapersAreaForm extends CFormModel
{
    public $length;
    public $width;
    public $title;

    public function rules()
    {
        return array(
            array('length', 'required', 'message' => 'Укажите длину необклеиваемой области'),
            array('width', 'required', 'message' => 'Укажите ширину необклеиваемой области'),
            array('title', 'required', 'message' => 'Укажите название необклеиваемой области')
        );
    }

    public function attributeLabels()
    {
        return array(
            'length' => 'Длина',
            'width' => 'Ширина',
            'title'=>'Название'
        );
    }



}