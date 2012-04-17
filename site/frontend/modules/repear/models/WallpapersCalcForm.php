<?php

class WallpapersCalcForm extends CFormModel
{
    public $room_length;
    public $room_width;
    public $room_height;
    public $wp_width;
    public $wp_length;
    public $repeat;

    public function rules()
    {
        return array(
            //array('room_length, room_width, room_height', 'normalizeLength'),
            //array('room_length, room_width, room_height', 'filter', 'filter'=> 'normalizeLength'),
            array('room_length', 'required', 'message' => 'Укажите длину помещения'),
            array('room_width', 'required', 'message' => 'Укажите ширину помещения'),
            array('room_height', 'required', 'message' => 'Укажите высоту помещения'),
            array('wp_width', 'required', 'message' => 'Укажите ширину обоев'),
            array('wp_length', 'required', 'message' => 'Укажите длину рулона'),
            array('repeat', 'required', 'message' => 'Укажите раппорт')
        );
    }

    public function attributeLabels()
    {
        return array(
            'room_length' => 'Длина помещения',
            'room_width' => 'Ширина помещения',
            'room_height'=>'Высота помещения',
            'wp_width'=>'Ширина обоев',
            'wp_length'=>'Длина рулона',
            'repeat'=>'Раппорт'
        );
    }

    public function normalizeLength($attribute, $params)
    {
        $this->$attribute = str_replace(',', '.', $this->$attribute);
        //$this->$attribute = preg_replace('#^[0-9\.]+$#', '', $this->$attribute);
    }
}