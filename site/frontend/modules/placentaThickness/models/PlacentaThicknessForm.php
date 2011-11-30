<?php

class PlacentaThicknessForm extends CFormModel
{
    public $thickness;
    public $week;

    public function rules()
    {
        return array(
            array('week, thickness', 'required'),
            array('week', 'numerical', 'integerOnly' => true, 'max' => 40, 'min'=>1),
            array('thickness', 'numerical', 'max' => 500, 'min' => 0),
            array('week, thickness', 'safe')
        );
    }

    public function attributeLabels()
    {
        return array(
        );
    }

    public function beforeValidate()
    {
        $this->thickness = str_replace(',', '.', $this->thickness);
        return parent::beforeValidate();
    }
}