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
            array('cross_count', 'required', 'message' => 'Укажите {attribute}'),
            array('threads_num, canva', 'required', 'message' => 'Выберите из списка {attribute}'),
            array('cross_count, threads_num, canva', 'numerical', 'integerOnly' => true, 'message' => 'Вводите только цифры'),
        );
    }

    public function AttributeLabels()
    {
        return array(
            'cross_count' => 'общее количество крестиков в работе',
            'threads_num' => 'сколько сложений нити вы будете использовать для вышивки',
            'canva' => 'номер канвы, планируемой для вышивания',
        );
    }
}
