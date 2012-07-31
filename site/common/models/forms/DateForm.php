<?php
/**
 * Author: alexk984
 * Date: 31.07.12
 */
class DateForm extends CFormModel
{
    public $day;
    public $month;
    public $year;

    public $date;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            array('day, month, year', 'required'),
            array('day, month, year', 'numerical', 'integerOnly' => true),
            array('date', 'date', 'format' => 'yyyy-MM-dd'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'day'=>'День',
            'month'=>'Месяц',
            'year'=>'Год',
            'date'=>'Дата',
        );
    }

    public function beforeValidate()
    {
        $this->date = $this->year.'-'.sprintf('%02d',$this->month).'-'.sprintf('%02d',$this->day);

        return parent::beforeValidate();
    }
}
