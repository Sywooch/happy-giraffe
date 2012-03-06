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
            array('sample_width_sm, sample_height_sm, sample_width_p, sample_height_p, width, height', 'required'),
            array('sample_width_sm, sample_height_sm, sample_width_p, sample_height_p, width, height', 'numerical', 'integerOnly' => true),
        );
    }

    public function AttributeLabels()
    {
        return array(
            'sample_width_sm'=>'Ширина образца в сантиметрах',
            'sample_height_sm'=>'Длина образца в сантиметрах',
            'sample_width_p'=>'Ширина образца в петлях',
            'sample_height_p'=>'Длина образца в петлях',
            'width'=>'Ширина изделия',
            'height'=>'Длина изделия',
        );
    }
}
