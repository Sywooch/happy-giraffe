<?php
/**
 * Author: choo
 * Date: 30.07.2012
 */
class CalendarPregnancyController extends BController
{
    public $section = 'club';
    public $layout = '//layouts/club';
    public $defaultAction = 'admin';
    public $_class = 'CalendarPeriod';
    public $authItem = 'calendar_pregnancy';

    public function init()
    {
        Yii::import('site.frontend.modules.calendar.models.*');
    }

    public function actions()
    {
        return array(
            'update' => 'application.components.actions.Update',
            'admin' => 'application.components.actions.Admin',
        );
    }

    /*public function actionGenerate()
    {
        $periods = array();
        $periods[] = 'Планирование';
        for ($i = 1; $i <= 40; $i++)
            $periods[] = $i . '-я неделя';
        $periods[] = 'Роды';
        foreach ($periods as $p) {
            $period = new CalendarPeriod;
            $period->title = $p;
            $period->calendar = 1;
            $period->save(false);
        }
    }*/
}