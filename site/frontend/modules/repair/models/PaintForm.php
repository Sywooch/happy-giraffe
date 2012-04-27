<?php

class PaintForm extends CFormModel
{
    public $roomLength;
    public $roomWidth;
    public $roomHeight;

    public $paints = array(1 => 'Водная краска', 2 => 'Эмаль', 3 => 'Силиконовая краска', 4 => 'Пластичная краска', 5 => 'Акриловая краска', 6 => 'Латексная, водонепроницаемая краска', 7 => 'Краска эластичная, противогрибковая', 8 => 'Пластиковая краска');
    public $paintsK = array(1 => 0.15, 2 => 0.12, 3 => 0.083, 4 => 0.083, 5 => 0.083, 6 => 0.1, 7 => 0.1, 8 => 0.125);

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