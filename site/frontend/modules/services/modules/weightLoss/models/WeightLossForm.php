<?php

class WeightLossForm extends HFormModel
{
    public $weight;
    //public $loss;
    public $days;
    public $growth;
    public $activity;
    public $sex;
    public $age;

    public function rules()
    {
        return array(
            array('weight, days, growth, activity, sex, age', 'required', 'message' => 'введите {attribute}'),
            array('weight, days', 'ext.validators.positiveNumber', 'message' => '{attribute} не может быть отрицательным'),
            array('weight, days', 'ext.validators.normalizeNumber', 'message' => 'Вводите цифры, допустимы дробные числа с запятой'),

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

        $result = array('input' => $this->attributes);

        $idealModel = new IdealWeightForm();
        $idealModel->attributes = array(
            'height' => $this->growth,
            'weight' => $this->weight
        );
        $result['idealWeight'] = $idealModel->calculate();
        $result['lossRight'] = ($result['idealWeight']['deviation'] > 0) ? $this->weight - $result['idealWeight']['result'] : 0;


        $dailyModel = new DailyCaloriesForm();
        $dailyModel->attributes = array(
            'sex' => $this->sex,
            'age' => $this->sex,
            'growth' => $this->growth,
            'weight' => $this->weight,
            'activity' => $this->activity
        );
        $result['dailyCalories'] = $dailyModel->calculate();


        if ($result['lossRight'] > 0) {

            $dailyDelta = ceil(9000 * $result['lossRight'] / $this->days);


            $result['dailyCaloriesLoss'] = $result['dailyCalories']['calories'] - $dailyDelta;
            if ($result['dailyCaloriesLoss'] < 0)
                $result['dailyCaloriesLoss'] = 0;

            $minCalories = ($this->sex == 1) ? 1800 : 1200;

            if ($dailyDelta > 1000)
                $dailyDelta = 1000;
            if (($result['dailyCalories']['calories'] - $dailyDelta) < $minCalories) {
                $dailyDelta = $result['dailyCalories']['calories'] - $minCalories;
                if ($dailyDelta < 0)
                    $dailyDelta = 100;
            }

            $result['dailyCaloriesRightLoss'] = $result['dailyCalories']['calories'] - $dailyDelta;
            $result['daysRight'] = $result['lossRight'] * 9000 / $dailyDelta;
        }

        return $result;
    }
}