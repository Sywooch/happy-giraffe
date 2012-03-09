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
            array('width, height, cross_price, material_price', 'required', 'message'=>'Введите {attribute}'),
            array('width, height, canva, colors_count', 'numerical', 'integerOnly' => true, 'message'=>'Вводите только цифры'),
            array('cross_price, material_price, design_price', 'numerical', 'message'=>'Вводите только цифры'),
        );
    }

    public function AttributeLabels()
    {
        return array(
            'width'=>'ширину картины в крестиках',
            'height'=>'высоту картины в крестиках',
            'cross_price'=>'стоимость одного крестика в рублях',
            'material_price'=>'стоимость материалов в рублях',
            'design_price'=>'Стоимость дизайна',
            'colors_count'=>'Количество цветов',
            'canva'=>'Размер канвы',
        );
    }
}
