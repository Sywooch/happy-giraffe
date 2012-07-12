<?php

class InterestController extends BController
{
    public $section = 'club';
    public $layout = '//layouts/club';
    public $defaultAction = 'admin';
    public $_class = 'Interest';
    public $authItem = 'interests';

    public function actions()
    {
        return array(
            'create' => 'application.components.actions.Create',
            'update' => 'application.components.actions.Update',
            'delete' => 'application.components.actions.Delete',
            'admin' => 'application.components.actions.Admin'
        );
    }
}
