<?php

class CookUnitController extends BController
{
    public $defaultAction = 'admin';
    public $section = 'club';
    public $layout = '//layouts/club';
    public $_class = 'CookUnit';
    public $authItem = 'cook_ingredients';

    public function actions()
    {
        return array(
            'create' => 'application.components.actions.Create',
            'update' => 'application.components.actions.Update',
            'delete' => 'application.components.actions.Delete',
            'admin' => 'application.components.actions.Admin'
        );
    }

    public function onCreateBeforeSave($vars)
    {
        $vars['model']->type = 'qty';
        $vars['model']->ratio = 1;
    }
}
