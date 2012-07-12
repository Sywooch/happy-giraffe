<?php

class HoroscopeController extends BController
{
    public $section = 'club';
    public $layout = '//layouts/club';
    public $defaultAction = 'admin';
    public $_class = 'Horoscope';
    public $authItem = 'horoscope';

    public function actions()
    {
        return array(
            'create' => 'application.components.actions.Create',
            'update' => 'application.components.actions.Update',
            'delete' => 'application.components.actions.Delete',
            'admin' => 'application.components.actions.Admin'
        );
    }

    public function onUpdateAfterSave($vars)
    {
        Yii::app()->cache->delete('HoroscopeWidget' . $vars['model']->zodiac . date("Y-m-d"));
    }
}
