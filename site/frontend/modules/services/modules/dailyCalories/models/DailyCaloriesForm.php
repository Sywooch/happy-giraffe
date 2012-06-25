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
        return true;
    }
}