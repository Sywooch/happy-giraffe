<?php

class BabyDateForm extends CFormModel
{
    public $day;
    public $month;
    public $gender;

    public function rules()
    {
        return array(
            array('month', 'required'),
            array('month, day, gender', 'safe'),
        );
    }

    public function init()
    {
        $this->day = date('j');
        $this->month = date('m');
    }

    public function CalculateData()
    {
        $criteria = new CDbCriteria;
        if (!empty($this->gender))
            $criteria->compare('gender', $this->gender);
        $criteria->compare('month', $this->month);

        if (empty($this->day))
            $criteria->order = 'day';
        else
            $criteria->compare('day', $this->day);

        $names = NameSaintDate::model()->with(array(
            'name' => array(
                'select' => array('id', 'name')
            )))->findAll($criteria);

        return $names;
    }
}