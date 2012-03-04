<?php

class ChinaCalendarForm extends CFormModel
{
    public $mother_m;
    public $mother_y;

    public $baby_m;
    public $baby_y;

    public $review_month;
    public $review_year;

    public function rules()
    {
        return array(
            array('mother_y, mother_m, baby_y, baby_m', 'required'),
            array('mother_y, mother_m, baby_y, baby_m', 'safe'),
        );
    }

    public function init()
    {
        $this->mother_y = date('Y')-25;
//        $this->mother_m = date('m');

        $this->baby_y = date('Y');
//        $this->baby_m = date('m');
    }

    public function beforeValidate()
    {


        return parent::beforeValidate();
    }
}