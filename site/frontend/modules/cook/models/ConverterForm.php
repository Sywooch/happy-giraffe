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
            array('qty', 'normalizeLength'),
            array('qty',  'numerical', 'allowEmpty'=>false, 'min'=>0.01, 'message' => 'Не корректно введен {attribute}'),
            array('from, to, ingredient', 'numerical', 'allowEmpty'=>false, 'message' => 'Не корректно введен {attribute}')
        );
    }

    public function attributeLabels()
    {
        return array(
            'from' => 'Ед. изм ИЗ',
            'to' => 'Ед. изм В',
            'qty' => 'количество',
            'ingredient' => 'продукт'
        );
    }

}