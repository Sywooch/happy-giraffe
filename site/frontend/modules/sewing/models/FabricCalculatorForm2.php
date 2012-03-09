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
            array('width, height', 'required', 'message'=>'Укажите {attribute}'),
            array('canva', 'required', 'message'=>'Выберите из списка {attribute}'),
            array('canva', 'numerical', 'integerOnly' => true, 'message'=>'Вводите только цифры'),
            array('additional', 'numerical', 'message' => 'Вводите только цифры (допустимы дробные числа)'),
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
            'width' => 'ширину изделия в стежках',
            'height' => 'высоту изделия в стежках',
            'additional' => 'сколько сантиметров будет от края вышивки до края изделия',
            'canva' => 'номер ткани, на которой Вы планируете вышивать',
        );
    }
}
