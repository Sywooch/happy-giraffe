<?php

class ConverterForm extends HFormModel
{
    public $from;
    public $to;
    public $qty;
    public $ingredient;

    public function rules()
    {
        return array(
            array('from, to, qty, ingredient', 'required', 'message' => 'Вы не выбрали {attribute}'),
            array('from, to, qty, ingredient', 'numerical', 'message' => 'Не корректно введен {attribute}')
        );
    }

    public function attributeLabels()
    {
        return array(
            'from' => 'Ед. изм ИЗ',
            'to' => 'Ед. изм В',
            'qty' => 'Количество',
            'ingredient' => 'продукт'
        );
    }

}