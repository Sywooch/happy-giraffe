<?php

class BodyFatForm extends HFormModel
{
    public $weight;
    public $height;
    public $waist;
    public $sex;

    public $sexes = array(0 => 'Ж', 1 => 'М');

    public function rules()
    {
        return array(
            array('weight, height, waist', 'ext.validators.positiveNumber', 'message' => '{attribute} не может быть отрицательным'),
            array('weight, height, waist', 'ext.validators.normalizeNumber', 'message' => 'Вводите цифры, допустимы дробные числа с запятой'),
            array('weight, height, waist, sex', 'required', 'message' => 'Укажите {attribute}'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'height' => 'Рост, см',
            'weight' => 'Вес, кг',
            'waist' => 'Талия, см',
            'sex' => 'Пол'
        );
    }

    public function calculate()
    {
        $result = array();

        if ($this->sex == 1) {
            $result['fatPercent'] = 0.31457 * $this->waist - 0.10969 * $this->weight + 10.834;
            $result['method'] = 'male';
        } else {
            $result['fatPercent'] = 100 - (0.11077 * $this->waist - 0.17666 * ($this->height / 100) + 0.14354 * $this->weight + 51.033);
            $result['method'] = 'female';
        }
        $result['fatPercent'] = ceil($result['fatPercent']);
        $result['fatWeight'] = ceil($this->weight * $result['fatPercent'] / 100);
        $result['bodyWeight'] = $this->weight - $result['fatWeight'];

        return $result;
    }
}