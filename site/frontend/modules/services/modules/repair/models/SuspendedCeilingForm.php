<?php

class SuspendedCeilingForm extends HFormModel
{
    public $area;
    public $plate;
    public $plateTypes = array(1 => 'Евростандарт (600х600)', 2 => 'Стандарт Америки (610х610)');

    public function rules()
    {
        return array(
            array('area', 'required', 'message' => 'Укажите площадь потолка'),
            array('area', 'ext.validators.positiveNumber'),
            array('area', 'ext.validators.normalizeNumber'),
            array('plate', 'required', 'message' => 'Укажите тип потолочной плиты'),
            array('area', 'numerical', 'message' => 'Введите число'),
            array('area', 'normalizeLength')
        );
    }

    public function attributeLabels()
    {
        return array(
            'area' => 'Площадь потолка',
            'plate' => 'Потолочная плита'
        );
    }

    public function calculate()
    {
        $r = array();
        if ($this->plate == 1) {
            $S = 0.36 * ceil($this->area / 0.36);
            $r['Плитка потолочная '] = ceil($S / 0.36);
            $r['Подвес'] = ceil($S * 0.5);
        } else {
            $S = 0.3721 * ceil($this->area / 0.3721);
            $r['Плитка потолочная '] = ceil($S / 0.3721);
            $r['Проволока'] = ceil($S * 0.12);
        }
        $r['Рейка - 3 м'] = ceil($S * 0.473 / 3);
        $r['Рейка несущая - 3.6 м'] = ceil($S * 0.732 / 3.6);
        $r['Рейка - 0.6 м'] = ceil($S * 1.3);
        $r['Рейка - 1.2 м'] = ceil($S * 1.3);
        return $r;
    }

}