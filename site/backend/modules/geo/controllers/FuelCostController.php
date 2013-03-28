<?php

class FuelCostController extends BController
{
    public $defaultAction = 'admin';
    //public $section = 'club';
    public $layout = '//layouts/club';
    public $_class = 'FuelCost';
    public $authItem = 'routes';//     <------ Insert AuthItem here

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
