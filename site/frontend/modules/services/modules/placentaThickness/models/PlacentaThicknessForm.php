<?php

class PlacentaThicknessForm extends CFormModel
{
    public $thickness;
    public $week;

    public function rules()
    {
        return array(
            array('thickness', 'ext.validators.normalizeNumber'),
            array('week', 'required', 'message' => 'Выберите свой срок беременности из списка'),
            array('thickness', 'required', 'message' => 'Укажите толщину плаценты в миллиметрах'),
            array('week', 'numerical', 'integerOnly' => true, 'max' => 40, 'min' => 7),
            array('thickness', 'numerical', 'message' => 'Вводите цифры, допустимы дробные числа с запятой'),
            array('thickness', 'numerical', 'max' => 500, 'min' => 0, 'message' => 'Проверьте, правильно ли введена толщина плаценты в миллиметрах (допустимо менее 300 мм)'),
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

    /*public function beforeValidate()
    {
        $this->thickness = str_replace(',', '.', $this->thickness);
        return parent::beforeValidate();
    }*/
}