<?php

class TileForm extends CFormModel
{
    public $roomLength;
    public $roomWidth;
    public $roomHeight;
    public $tileLength;
    public $tileWidth;

    public function rules()
    {
        return array(
            array('roomLength', 'required', 'message' => 'Укажите длину помещения'),
            array('roomWidth', 'required', 'message' => 'Укажите ширину помещения'),
            array('roomHeight', 'required', 'message' => 'Укажите высоту помещения'),
            array('tileLength', 'required', 'message' => 'Укажите длину рулона'),
            array('tileWidth', 'required', 'message' => 'Укажите ширину обоев'),
            array('roomLength, roomWidth, roomHeight, tileLength, tileWidth', 'normalizeLength'),
            array('roomLength, roomWidth, roomHeight, tileLength, tileWidth', 'numerical', 'message' => 'Введите число')
        );
    }

    public function attributeLabels()
    {
        return array(
            'roomLength' => 'Длина ванной',
            'roomWidth' => 'Ширина ванной',
            'roomHeight' => 'Высота ванной',
            'tileLength' => 'Длина плитки',
            'tileWidth' => 'Ширина плитки',
        );
    }

    public function normalizeLength($attribute, $params)
    {
        $this->$attribute = trim(str_replace(',', '.', $this->$attribute));
        $this->$attribute = preg_replace('#[^0-9\.]+#', '', $this->$attribute);
    }

    public function calculate()
    {
        $tiles = ((ceil($this->roomLength / $this->tileLength) * ceil($this->roomHeight / $this->tileWidth)) * 2) +
            ((ceil($this->roomWidth / $this->tileLength) * ceil($this->roomHeight / $this->tileWidth)) * 2);
        $areas = Yii::app()->user->getState('repairTileAreas');
        if (count($areas)) {
            foreach ($areas as $area) {
                $tiles -= floor($area['height'] / $this->tileLength) * floor($area['width'] / $this->tileWidth);
            }
        }
        return $tiles;
    }
}