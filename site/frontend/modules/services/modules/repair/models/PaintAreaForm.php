<?php

class PaintAreaForm extends HFormModel
{
    public $height;
    public $width;
    public $title;
    public $qty;

    public function rules()
    {
        return array(
            array('height', 'required', 'message' => 'Укажите высоту неокрашиваемой области'),
            array('width', 'required', 'message' => 'Укажите ширину неокрашиваемой области'),
            array('title', 'required', 'message' => 'Укажите название неокрашиваемой области'),
            array('qty', 'default', 'value' => 1),
            array('qty', 'required', 'message' => 'Укажите кол-во неокрашиваемых областей'),
            array('height, width', 'normalizeLength'),
            array('height, width', 'numerical', 'message' => '{attribute} должна быть числом')
        );
    }

    public function attributeLabels()
    {
        return array(
            'height' => 'Высота',
            'width' => 'Ширина',
            'title' => 'Название',
            'qty' => 'кол-во'
        );
    }
}