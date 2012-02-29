<?php

class DateForm extends CFormModel
{
    public $day;
    public $month;
    public $year;

    public $date;

    public function rules()
    {
        return array(
            array('day, month, year', 'required'),
            array('day, month, year', 'numerical', 'integerOnly' => true),
        );
    }

    public function beforeValidate()
    {
        $this->date = strtotime($this->day . '-' . $this->month . '-' . $this->year);

        return parent::beforeValidate();
    }
}