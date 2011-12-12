<?php

class MenstrualCycleForm extends CFormModel
{
    //day, month, year of cycle start
    public $day;
    public $month;
    public $year;

    public $cycle;
    public $critical_period;

    /**
     * @var int mother born date
     */
    public $start_date;

    public function rules()
    {
        return array(
            array('day, month, year, cycle, critical_period', 'required'),
        );
    }

    public function init()
    {
        if (!Yii::app()->user->isGuest) {
            $user_cycle = MenstrualCycle::GetUserCycle(Yii::app()->user->getId());
            $this->day = date('j', strtotime($user_cycle['date']));
            $this->month = date('m', strtotime($user_cycle['date']));
            $this->year = date('Y', strtotime($user_cycle['date']));
            $this->cycle = $user_cycle['cycle'];
            $this->critical_period = $user_cycle['menstruation'];
        } else {
            $this->day = date('j');
            $this->month = date('m');
            $this->year = date('Y');
            $this->cycle = 25;
            $this->critical_period = 5;
        }
    }

    public function beforeValidate()
    {
        $this->start_date = strtotime($this->day . '-' . $this->month . '-' . $this->year);

        return parent::beforeValidate();
    }

}