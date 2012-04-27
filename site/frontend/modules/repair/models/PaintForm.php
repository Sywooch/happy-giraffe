<?php

class PaintForm extends CFormModel
{
    public $roomLength;
    public $roomWidth;
    public $roomHeight;
    public $paintType;
    public $surface;

    public $paints = array(1 => 'Водная краска', 2 => 'Эмаль', 3 => 'Силиконовая краска', 4 => 'Пластичная краска', 5 => 'Акриловая краска', 6 => 'Латексная, водонепроницаемая краска', 7 => 'Краска эластичная, противогрибковая', 8 => 'Пластиковая краска');
    public $paintsK = array(1 => 0.15, 2 => 0.12, 3 => 0.083, 4 => 0.083, 5 => 0.083, 6 => 0.1, 7 => 0.1, 8 => 0.125);

    public function rules()
    {
        return array(
            array('surface', 'required'),
            array('roomLength', 'required', 'message' => 'Укажите длину помещения'),
            array('roomWidth', 'required', 'message' => 'Укажите ширину помещения'),
            //array('roomHeight', 'required', 'message' => 'Укажите высоту помещения'),
            array('roomHeight', 'validateRoomHeight'),
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
            'paintType' => 'Чем красим?',
            'wall' => 'окрашиваемая поверхность'
        );
    }

    public function normalizeLength($attribute, $params)
    {
        $this->$attribute = trim(str_replace(',', '.', $this->$attribute));
        $this->$attribute = preg_replace('#[^0-9\.]+#', '', $this->$attribute);
    }

    public function validateRoomHeight($attribute, $params)
    {
        if ($this->surface == "Стены") {

            if (!$this->$attribute) {
                $this->addError($attribute, 'Укажите высоту помещения');
                return;
            }
            $this->normalizeLength($attribute, $params);
            if (!preg_match('#^[0-9\.]+$#', $this->$attribute)) {
                $this->addError($attribute, 'Введите число');
            }
        }
    }

    public function calculate()
    {
        $sq = ($this->surface == "Стены") ? ($this->roomHeight * (($this->roomLength + $this->roomWidth) * 2)) : ($this->roomLength * $this->roomWidth);
        $areas = Yii::app()->user->getState('wallpapersCalcAreas');
        if ($this->surface == "Стены") {
            $areas = Yii::app()->user->getState('emptyAreas');
            if (count($areas)) {
                foreach ($areas as $area) {
                    $sq -= $area['height'] * $area['width'] * $area['qty'];
                }
            }
        }
        $result['volume'] = ceil($sq * $this->paintsK[$this->paintType]);
        $result['noun'] = HDate::GenerateNoun(array('литр', 'литра', 'литров'),$result['volume']);

        return $result;
    }

    public function calculate_old()
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