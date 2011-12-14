<?php

class ChinaCalendarForm extends CFormModel
{
    const IS_BOY = 1;
    const IS_GIRL = 2;

    //day, month, year of mother born
    public $mother_m;
    public $mother_y;
    public $mother_born_date;

    public $baby_m;
    public $baby_y;
    public $baby_date;

    public $review_month;
    public $review_year;

    public function rules()
    {
        return array(
            array('mother_y, mother_m, baby_y, baby_m', 'required'),
        );
    }

    public function init()
    {
        $this->mother_y = date('Y')-25;
        $this->mother_m = date('m');

        $this->baby_y = date('Y');
        $this->baby_m = date('m');
    }

    public function beforeValidate()
    {
        $this->mother_born_date = strtotime('1' . '-' . $this->mother_m . '-' . $this->mother_y);
        $this->baby_date = strtotime('1' . '-' . $this->baby_m . '-' . $this->baby_y);

        if (empty($this->review_month))
            $this->review_month = $this->baby_m;
        if (empty($this->review_year))
            $this->review_year = $this->baby_y;

        return parent::beforeValidate();
    }

    public function CalculateData()
    {

    }
}