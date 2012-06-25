<?php

class DailyCaloriesForm extends HFormModel
{
    public $sex;
    public $age;
    public $growth;
    public $weight;
    public $activity;
    public $activities = array(
        '1.2' => 'Сидячий образ жизни',
        '1.375' => 'Небольшая активность',
        '1.55' => 'Умеренная активность',
        '1.725' => 'Высокая активность',
        '1.9' => 'Очень высокая активность'
    );

    public $sexes = array(0 => 'Ж', 1 => 'М');

    public function rules()
    {
        return array(
            array('sex, age, growth, weight, activity', 'required', 'message' => 'Укажите {attribute}'),
            array('age, growth, weight', 'numerical', 'message' => 'Введите число')
            //array('growth, weight', 'normalizeLength')
        );
    }

    public function attributeLabels()
    {
        return array(
            'sex' => 'Пол',
            'age' => 'Возраст',
            'growth' => 'Рост',
            'weight' => 'Вес',
            'activity' => 'Активность'
        );
    }

    public function calculate()
    {
        $result = array();
        $result['calories'] = ($this->sex) ? 10 * $this->weight + 6.25 * $this->growth - 5 * $this->age + 5 : 10 * $this->weight + 6.25 * $this->growth - 5 * $this->age - 161;
        $result['calories'] *= $this->activity;
        $result['calories'] = ceil($result['calories']);

        $result['protein'] = ceil(($result['calories'] * (4 / 17)) * (1 / 6));
        $result['fats'] = ceil(($result['calories'] * (9 / 17)) * (1 / 6));
        $result['carbs'] = ceil(($result['calories'] * (4 / 17)) * (4 / 6));

        return $result;
    }
}