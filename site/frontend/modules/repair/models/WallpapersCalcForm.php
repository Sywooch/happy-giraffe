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
            array('room_length', 'required', 'message' => 'Укажите длину помещения'),
            array('room_width', 'required', 'message' => 'Укажите ширину помещения'),
            array('room_height', 'required', 'message' => 'Укажите высоту помещения'),
            array('wp_width', 'required', 'message' => 'Укажите ширину обоев'),
            array('wp_length', 'required', 'message' => 'Укажите длину рулона'),
            //array('repeat', 'required', 'message' => 'Укажите раппорт'),
            //array('room_length, room_width, room_height, wp_width, wp_length, repeat', 'filter', 'filter'=>'trim'),
            array('room_length, room_width, room_height, wp_width, wp_length, repeat', 'normalizeLength'),
            array('room_length, room_width, room_height, wp_width, wp_length, repeat', 'numerical', 'message' => 'Введите число')

        );
    }

    public function attributeLabels()
    {
        return array(
            'room_length' => 'Длина помещения',
            'room_width' => 'Ширина помещения',
            'room_height' => 'Высота помещения',
            'wp_width' => 'Ширина обоев',
            'wp_length' => 'Длина рулона',
            'repeat' => 'Раппорт'
        );
    }

    public function normalizeLength($attribute, $params)
    {
        $this->$attribute = trim(str_replace(',', '.', $this->$attribute));
        $this->$attribute = preg_replace('#[^0-9\.]+#', '', $this->$attribute);
    }

    public function calculate()
    {
        $session = new CHttpSession;
        $session->open();
        $areas = $session['wallpapersCalcAreas'];
        $perimeter = ($this->room_length + $this->room_width) * 2;
        $lines = ceil($perimeter / $this->wp_width);
        if ($this->repeat) {
            $tiles = (ceil($this->room_height / $this->repeat)) * $lines;
            if (count($areas)) {
                foreach ($areas as $area) {
                    $tiles -= (floor($area['width'] / $this->wp_width) * floor($area['height'] / $this->repeat));
                }
            }
            return ceil($tiles / (floor($this->wp_length / $this->repeat)));
        } else {
            $length = $lines * ($this->room_height + 0.1);
            if (count($areas)) {
                foreach ($areas as $area) {
                    $length -= (floor($area['width'] / $this->wp_width) * $area['height']);
                }
            }
            return ceil($length / $this->wp_length);
        }
    }
}