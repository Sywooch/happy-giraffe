<?php

class PregnantParamsForm extends CFormModel
{
    public $height;
    public $weight;
    public $week;
    public $weight_before;
    //body mass index
    public $bmi;

    public function rules()
    {
        return array(
            array('height, weight, week, weight_before', 'required'),
            array('height, weight, week, weight_before', 'numerical', 'integerOnly' => true),
            array('height', 'numerical', 'max' => 250, 'min'=>80),
            array('weight, weight_before', 'numerical', 'max' => 1000, 'min'=>20),
            array('week', 'numerical', 'max' => 40, 'min'=>1),
            array('height, weight, week, weight_before', 'safe')
        );
    }

    public function attributeLabels()
    {
        return array(

        );
    }

    public function afterValidate(){
        //height in meters
        $this->height = $this->height / 100;
        $this->bmi = $this->weight_before / ($this->height * $this->height);

    }
}