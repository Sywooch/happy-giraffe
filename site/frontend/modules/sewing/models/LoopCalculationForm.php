<?php
/**
 * Author: alexk984
 * Date: 06.03.12
 */
class LoopCalculationForm extends CFormModel
{
    public $sample_width_sm;
    public $sample_height_sm;
    public $sample_width_p;
    public $sample_height_p;
    public $width;
    public $height;

    public function rules()
    {
        return array(
            array('sample_width_sm, sample_height_sm, sample_width_p, sample_height_p, width, height', 'required', 'message'=>'Введите {attribute}'),
            array('sample_width_sm, sample_height_sm, sample_width_p, sample_height_p, width, height', 'numerical', 'integerOnly' => true, 'message'=>'Вводите только цифры'),
        );
    }

    public function AttributeLabels()
    {
        return array(
            'sample_width_sm'=>'ширину образца в сантиметрах',
            'sample_height_sm'=>'длину образца в сантиметрах',
            'sample_width_p'=>'ширину образца в петлях',
            'sample_height_p'=>'длину образца в петлях',
            'width'=>'ширину изделия в сантиметрах',
            'height'=>'длину изделия в сантиметрах',
        );
    }
}
