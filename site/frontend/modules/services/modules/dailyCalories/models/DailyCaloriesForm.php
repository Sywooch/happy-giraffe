<?php

class DailyCaloriesForm extends HFormModel
{
    public $sex;
    public $age;
    public $growth;
    public $weight;
    public $activity;

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

        return $result;
    }
}