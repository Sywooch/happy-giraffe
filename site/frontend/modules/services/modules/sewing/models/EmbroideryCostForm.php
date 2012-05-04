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

    public $more_colors;
    public $small_canva;
    public $user_design;

    public $model;

    public function rules()
    {
        return array(
            array('width, height, cross_price, material_price', 'required', 'message'=>'Введите {attribute}'),
            array('width, height, canva, colors_count', 'numerical', 'integerOnly' => true, 'message'=>'Вводите только цифры'),
            array('cross_price, material_price, design_price', 'numerical', 'message'=>'Вводите только цифры'),
            array('small_canva, more_colors, user_design', 'safe')
        );
    }

    public function AttributeLabels()
    {
        return array(
            'width'=>'ширину картины в крестиках',
            'height'=>'высоту картины в крестиках',
            'cross_price'=>'стоимость одного крестика в рублях',
            'material_price'=>'стоимость материалов в рублях',
            'design_price'=>'стоимость дизайна',
            'colors_count'=>'количество цветов',
            'canva'=>'размер канвы',
        );
    }

    public function afterValidate()
    {
        if ($this->small_canva && empty($this->canva))
            $this->addError('canva', 'Введите размер канвы');

        if ($this->more_colors && empty($this->colors_count))
            $this->addError('colors_count', 'Введите количество цветов');

        if ($this->user_design && empty($this->design_price))
            $this->addError('design_price', 'Введите стоимость вашего дизайна');

        parent::afterValidate();
    }
}
