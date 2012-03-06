<?php
/**
 * Author: alexk984
 * Date: 06.03.12
 */
class ThreadCalculationForm extends CFormModel
{
    public $cross_count;
    public $threads_num;
    public $canva;

    public function rules()
    {
        return array(
            array('cross_count, threads_num, canva', 'required'),
            array('cross_count, threads_num, canva', 'numerical', 'integerOnly' => true),
        );
    }

    public function AttributeLabels()
    {
        return array(
            'cross_count' => 'Количество крестиков',
            'threads_num' => 'Сложений нити',
            'canva' => 'Номер канвы Aida',
        );
    }
}
