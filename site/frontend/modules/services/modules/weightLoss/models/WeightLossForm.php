<?php

class WeightLossForm extends HFormModel
{
    public $weight;
    public $loss;
    public $days;

    public function rules()
    {
        return array(
            array('weight, days, loss', 'required', 'message' => 'введите {attribute}'),
            array('weight, days, loss', 'ext.validators.positiveNumber', 'message' => '{attribute} не может быть отрицательным'),
            array('weight, days, loss', 'ext.validators.normalizeNumber', 'message' => 'Вводите цифры, допустимы дробные числа с запятой'),

            array('days', 'numerical', 'integerOnly' => true, 'message' => 'Введите целое число'),
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
            'weight' => 'Вес, кг',
            'loss' => 'похудедение, кг',
            'days' => 'в течении скольких дней'
        );
    }

    public function calculate()
    {
        $result = array('dailyCalories' => 0, 'days' => 0);
        $result['dailyCalories'] = ceil(9000 * $this->loss / $this->days);
        if ($result['dailyCalories'] > 1000)
            $result['days'] = ceil(9000 * $this->loss / 1000);

        return $result;
    }
}