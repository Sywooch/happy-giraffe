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
            array('mother_y, mother_m, baby_y, baby_m', 'required', 'message'=>'Выберите из списка {attribute}'),
            array('mother_y, mother_m, baby_y, baby_m', 'safe'),
        );
    }

    public function AttributeLabels()
    {
        return array(
            'mother_y'=>'год рождения матери',
            'mother_m'=>'месяц рождения матери ребенка',
            'baby_y'=>'год зачатия ребенка',
            'baby_m'=>'месяц зачатия ребенка',
        );
    }
}