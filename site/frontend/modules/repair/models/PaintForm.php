<?php

class PaintForm extends CFormModel
{
    public $roomLength;
    public $roomWidth;
    public $roomHeight;


    public function rules()
    {
        return array(
            array('roomLength', 'required', 'message' => 'Укажите длину помещения'),
            array('roomWidth', 'required', 'message' => 'Укажите ширину помещения'),
            array('roomHeight', 'required', 'message' => 'Укажите высоту помещения'),
            array('paintType', 'required', 'message' => 'Укажите тип краски'),

            array('roomLength, roomWidth, roomHeight', 'normalizeLength'),
            array('roomLength, roomWidth, roomHeight', 'numerical', 'message' => 'Введите число')

        );
    }

    public function attributeLabels()
    {
        return array(
            'roomLength' => 'Длина помещения',
            'roomWidth' => 'Ширина помещения',
            'roomHeight' => 'Высота помещения',
            'paintType' => 'Чем красим?'
        );
    }

    public function normalizeLength($attribute, $params)
    {
        $this->$attribute = trim(str_replace(',', '.', $this->$attribute));
        $this->$attribute = preg_replace('#[^0-9\.]+#', '', $this->$attribute);
    }

    public function calculate()
    {

        $areas = Yii::app()->user->getState('wallpapersCalcAreas');
        $perimeter = ($this->roomLength + $this->roomWidth) * 2;
        $lines = ceil($perimeter / $this->wp_width);
        if ($this->repeat) {
            $tiles = (ceil($this->roomHeight / $this->repeat)) * $lines;
            if (count($areas)) {
                foreach ($areas as $area) {
                    $tiles -= (floor($area['width'] / $this->wp_width) * floor($area['height'] / $this->repeat));
                }
            }
            return ceil($tiles / (floor($this->wp_length / $this->repeat)));
        } else {
            $length = $lines * ($this->roomHeight + 0.1);
            if (count($areas)) {
                foreach ($areas as $area) {
                    $length -= (floor($area['width'] / $this->wp_width) * $area['height']);
                }
            }
            return ceil($length / $this->wp_length);
        }
    }
}