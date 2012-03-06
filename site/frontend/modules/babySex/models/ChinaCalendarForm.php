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

    public function AttributeLabels()
    {
        return array(
            'mother_y'=>'Год рождения матери',
            'mother_m'=>'Месяц рождения матери',
            'baby_y'=>'Год зачатия ребенка',
            'baby_m'=>'Месяц зачатия ребенка',
        );
    }
}