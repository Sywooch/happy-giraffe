<?php

class PlacentaThicknessForm extends CFormModel
{
    public $thickness;
    public $week;

    public function rules()
    {
        return array(
            array('week', 'required', 'message' => 'Укажите срок беременности<br/>(диапазон 7-40 недель)'),
            array('thickness', 'required', 'message' => 'Укажите толщину плаценты'),
            array('week', 'numerical', 'integerOnly' => true, 'max' => 40, 'min' => 7),
            array('thickness', 'numerical', 'max' => 500, 'min' => 0, 'message' => 'Введите целое или дробное число,<br/>например 25 или 25,37'),
            array('week, thickness', 'safe')
        );
    }

    public function attributeLabels()
    {
        return array(
            'week' => 'Неделя беремнности',
            'thickness' => 'Толщина плаценты',
        );
    }

    public function beforeValidate()
    {
        $this->thickness = str_replace(',', '.', $this->thickness);
        return parent::beforeValidate();
    }
}