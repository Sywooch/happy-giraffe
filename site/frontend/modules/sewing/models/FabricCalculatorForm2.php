<?php
/**
 * Author: alexk984
 * Date: 06.03.12
 */
class FabricCalculatorForm2 extends CFormModel
{
    public $width;
    public $height;
    public $threads_num;
    public $additional;
    public $canva;

    public function rules()
    {
        return array(
            array('width, height, additional, canva', 'required'),
            array('width, height, threads_num, canva', 'numerical', 'integerOnly' => true),
            array('additional', 'numerical'),
        );
    }

    public function beforeValidate()
    {
        $this->additional = str_replace(',', '.', $this->additional);
        return parent::beforeValidate();
    }

    public function AttributeLabels()
    {
        return array(
            'width' => 'Ширина схемы в стяжках',
            'height' => 'Высота схемы в стяжках',
            'threads_num' => 'Количество нитей для одного "креста"',
            'additional' => 'Припуски',
            'canva' => 'Номер ткани',
        );
    }
}
