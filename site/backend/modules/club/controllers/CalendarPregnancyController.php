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
}