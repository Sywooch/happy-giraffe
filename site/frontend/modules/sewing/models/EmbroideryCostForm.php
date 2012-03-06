<?php
/**
 * User: alexk984
 * Date: 06.03.12
 */
class EmbroideryCostForm extends CFormModel
{
    public $width;
    public $height;
    public $cross_price;
    public $material_price;
    public $design_price;
    public $colors_count;
    public $canva;

    /**
     * @var YarnProjects
     */
    public $model;

    public function rules()
    {
        return array(
            array('width, height, cross_price, material_price', 'required'),
            array('width, height, canva, colors_count', 'numerical', 'integerOnly' => true),
            array('cross_price, material_price, design_price', 'numerical'),
        );
    }

    public function AttributeLabels()
    {
        return array(
            'width'=>'Ширина картины в "крестиках"',
            'height'=>'Высота картины в "крестиках"',
            'cross_price'=>'Стоимость одного "крестика"',
            'material_price'=>'Стоимость материала',
            'design_price'=>'Стоимость дизайна',
            'colors_count'=>'Количество цветов',
            'canva'=>'Размер канвы',
        );
    }
}
