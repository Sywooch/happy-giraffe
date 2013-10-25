<?php

class TileForm extends HFormModel
{
    public $wallLength;
    public $roomHeight;
    public $bathHeight;
    public $bathLength;
    public $doorHeight;
    public $doorWidth;
    public $tileLength;
    public $tileWidth;

    public function rules()
    {
        return array(
            array('wallLength', 'required', 'message' => 'Укажите длину всех стен'),
            array('roomHeight', 'required', 'message' => 'Укажите высоту стены'),
            array('bathLength', 'required', 'message' => 'Укажите длину ванной'),
            array('bathHeight', 'required', 'message' => 'Укажите высоту ванной'),
            array('doorHeight', 'required', 'message' => 'Укажите высоту двери'),
            array('doorWidth', 'required', 'message' => 'Укажите ширину двери'),
            array('tileLength', 'required', 'message' => 'Укажите длину рулона'),
            array('tileWidth', 'required', 'message' => 'Укажите ширину обоев'),
            array('wallLength, roomHeight, bathLength, bathHeight, doorHeight, doorWidth, tileLength, tileWidth', 'normalizeLength'),
            array('wallLength, roomHeight, bathLength, bathHeight, doorHeight, doorWidth, tileLength, tileWidth', 'numerical', 'message' => '{attribute} должна быть числом')
        );
    }

    public function attributeLabels()
    {
        return array(
            'wallLength' => 'Длина всех стен',
            'roomHeight' => 'Высота стены',
            'bathLength' => 'Длина ванной',
            'bathHeight' => 'Высота ванной',
            'doorHeight' => 'Высота двери',
            'doorWidth' => 'Ширина двери',
            'tileLength' => 'Длина плитки',
            'tileWidth' => 'Ширина плитки',
        );
    }

    public function calculate()
    {
        $tiles = ceil($this->wallLength / $this->tileLength) * ceil($this->roomHeight / $this->tileWidth);
        $tiles -= floor($this->bathHeight / $this->tileLength) * floor($this->bathLength / $this->tileWidth);
        $tiles -= floor($this->doorHeight / $this->tileLength) * floor($this->doorWidth / $this->tileWidth);

        if ($tiles < 0)
            $tiles = 0;

        return array('qty' => $tiles, 'noun' => Str::GenerateNoun(array('штука', 'штуки', 'штук'), $tiles));
    }
}