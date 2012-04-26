<?php

class PaintAreaForm extends CFormModel
{
    public $height;
    public $width;
    public $title;
    public $qty;

    public function rules()
    {
        return array(
            array('height', 'required', 'message' => 'Укажите высоту необклеиваемой области'),
            array('width', 'required', 'message' => 'Укажите ширину необклеиваемой области'),
            array('title', 'required', 'message' => 'Укажите название необклеиваемой области'),
            array('qty', 'default', 'value' => 1),
            array('qty', 'required', 'message' => 'Укажите кол-во необклеиваемых областей'),
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
            'qty' => 'кол-во'
        );
    }

    public function normalizeLength($attribute, $params)
    {
        $this->$attribute = trim(str_replace(',', '.', $this->$attribute));
        $this->$attribute = preg_replace('#[^0-9\.]+#', '', $this->$attribute);
    }


}