<?php

class PlacentaThicknessForm extends CFormModel
{
    public $thickness;
    public $week;

    public function rules()
    {
        return array(
            array('thickness', 'ext.validators.normalizeNumber', 'message' => 'Вводите цифры, допустимы дробные числа с запятой'),
            array('week', 'required', 'message' => 'Выберите свой срок беременности из списка'),
            array('thickness', 'required', 'message' => 'Укажите толщину плаценты в миллиметрах'),
            array('week', 'numerical', 'integerOnly' => true, 'max' => 40, 'min' => 7),
            //array('thickness', 'numerical', 'message' => 'Вводите цифры, допустимы дробные числа с запятой'),
            array('thickness', 'numerical', 'max' => 500, 'min' => 0,
                'message' => 'Вводите цифры, допустимы дробные числа с запятой',
                'tooBig' => 'Толщина плаценты слишком велика (максимум 500)',
                'tooSmall' => 'Толщина плаценты должна быть больше ноля'
            ),
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