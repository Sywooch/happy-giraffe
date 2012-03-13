<?php

class PregnantParamsForm extends CFormModel
{
    public $height;
    public $weight;
    public $week;
    public $weight_before;
    //body mass index
    public $bmi;

    public $recommend_gain;
    public $recommend_weight;
    /**
     * Data Array with weeks and recommend weight for week
     * @var array
     */
    public $data;
    public $normal_weight;
    public $min_weight;
    public $max_weight;

    public function rules()
    {
        return array(
            array('height', 'required', 'message' => 'Укажите рост в сантиметрах'),
            array('weight', 'required', 'message' => 'Укажите вес в килограммах в настоящее время'),
            array('week', 'required', 'message' => 'Выберите свой срок беременности из списка'),
            array('weight_before', 'required', 'message' => 'Укажите вес до беременности в килограммах'),
            array('week', 'numerical', 'integerOnly' => true),
            array('height', 'numerical', 'max' => 250, 'min' => 80, 'message' => 'Вводите только цифры',
                'tooBig' => 'Проверьте, правильно ли введён рост (допустимо менее 250 см)',
                'tooSmall' => 'Проверьте, правильно ли введён рост (допустимо более 80 см)'),
            array('weight, weight_before', 'numerical', 'max' => 1000, 'min' => 20, 'message' => 'Вводите только цифры',
                'tooBig' => 'Проверьте, правильно ли введён вес (допустимо менее 300 кг)',
                'tooSmall' => 'Проверьте, правильно ли введён вес (допустимо более 20 кг)'),
            array('week', 'numerical', 'max' => 40, 'min' => 1),
            array('height, weight, week, weight_before', 'safe')
        );
    }

    public function attributeLabels()
    {
        return array(
            'height' => 'Рост',
            'weight' => 'Сейчас мой вес',
            'week' => 'Неделя беременности',
            'weight_before' => 'Вес до беременности',
        );
    }

    public function beforeValidate()
    {
        $this->height = str_replace(',', '.', $this->height);
        $this->weight = str_replace(',', '.', $this->weight);
        $this->weight_before = str_replace(',', '.', $this->weight_before);
        return parent::beforeValidate();
    }

    public function afterValidate()
    {
        return parent::afterValidate();
    }

    public function CalculateData()
    {
        //height in meters
        $this->height = $this->height / 100;
        $this->bmi = $this->weight_before / ($this->height * $this->height);

        $this->recommend_gain = PregnancyWeight::GetWeightGainByWeekAndBMI($this->week, $this->bmi);
        $this->recommend_weight = $this->weight_before + (float)$this->recommend_gain;
        $this->data = PregnancyWeight::GetUserWeightArray($this->weight_before, $this->bmi);
        $this->normal_weight = $this->GetNormalWeight();
    }

    public function GetNormalWeight()
    {
        $this->min_weight = round($this->recommend_weight - $this->recommend_gain * 0.1, 1);
        $this->max_weight = round($this->recommend_weight + $this->recommend_gain * 0.1, 1);
        if ($this->min_weight == $this->max_weight)
            return $this->max_weight;
        return $this->min_weight . '-' . $this->max_weight;
    }
}