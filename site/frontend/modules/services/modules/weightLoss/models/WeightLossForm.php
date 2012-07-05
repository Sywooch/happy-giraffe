<?php

class WeightLossForm extends HFormModel
{
    public $weight;
    public $loss;
    public $days;
    public $growth;
    public $activity;
    public $sex;
    public $age;

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
            'days' => 'в течении скольких дней',
            'sex' => 'Пол',
            'age' => 'Возраст',
            'growth' => 'Рост',
            'activity' => 'Активность'
        );
    }

    public function calculate()
    {

        $result = array();

        $idealModel = new IdealWeightForm();
        $idealModel->attributes = array(
            'height' => $this->growth,
            'weight' => $this->weight
        );
        $result['idealWeight'] = $idealModel->calculate();

        $lossRight = ($result['idealWeight']['deviation'] > 100) ? $this->weight - $result['idealWeight']['result'] : 0;


        $dailyModel = new DailyCaloriesForm();
        $dailyModel->attributes = array(
            'sex' => $this->sex,
            'age' => $this->sex,
            'growth' => $this->growth,
            'weight' => $this->weight,
            'activity' => $this->activity
        );


        $result['dailyCalories'] = $dailyModel->calculate();

        $result['dailyCaloriesLoss'] = ceil(9000 * $lossRight / $this->days);
        if ($result['dailyCaloriesLoss'] < 0)
            $result['dailyCaloriesLoss'] = 0;


        $minCalories = ($this->sex == 1) ? 1800 : 1200;
        $minFact = $result['dailyCalories']['calories'] - $result['dailyCaloriesLoss'];
        if ($minCalories > $minFact) {
            $result['dailyCaloriesLossRight'] = $result['dailyCalories']['calories'] - $minCalories;
        }

        if ($result['dailyCaloriesLossRight'] < 0) {
            $result['dailyCaloriesLossRight'] = 200;
        }

        if ($result['dailyCaloriesLossRight'] > 1000) {
            $result['dailyCaloriesLossRight'] = 1000;
        }

        $result['days'] = ceil(9000 * $lossRight / $result['dailyCaloriesLossRight']);

        /*$result = array('dailyCalories' => 0, 'days' => 0);

        if ($result['dailyCalories'] > 1000)
            $result['days'] = ceil(9000 * $this->loss / 1000);*/

        return $result;
    }
}