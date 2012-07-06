<?php

class IdealWeightForm extends HFormModel
{
    public $weight;
    public $height;

    public function rules()
    {
        return array(
            array('weight, height', 'ext.validators.positiveNumber', 'message' => '{attribute} не может быть отрицательным'),
            array('weight, height', 'ext.validators.normalizeNumber', 'message' => 'Вводите цифры, допустимы дробные числа с запятой'),
            array('weight, height', 'required', 'message' => 'Укажите {attribute}'),
            array('height', 'numerical',
                'min' => 100,
                'tooSmall' => 'Допустимый рост от 100 см',
                'max' => 220,
                'tooBig' => 'Допустимый рост до 220 см',
                'message' => 'Введите число'
            ),
            array('weight', 'numerical',
                'min' => 30,
                'tooSmall' => 'Допустимый вес от 30 кг',
                'max' => 200,
                'tooBig' => 'Допустимый рост до 200 кг',
                'message' => 'Введите число'
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'height' => 'Рост',
            'weight' => 'Вес'
        );
    }

    public function calculate()
    {
        $result = array('formulas' => array(), 'result' => 0, 'input' => $this->attributes);
        if ($this->height >= 155 and $this->height <= 170)
            $result['formulas']['broka'] = $this->height - 100;
        $result['formulas']['braitman'] = $this->height * 0.7 - 50;
        $result['formulas']['noorden'] = $this->height * 0.42;
        $result['formulas']['taton'] = $this->height - (100 + ($this->height - 100) / 20);

        $result['result'] = ceil(array_sum($result['formulas']) / count($result['formulas']));

        $result['deviation'] = ceil(($this->weight / $result['result'] * 100) - 100);

        return $result;
    }
}