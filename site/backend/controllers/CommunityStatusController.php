<?php

class CommunityStatusController extends BController
{
    public $defaultAction = 'admin';
    //public $section = 'club';
    public $layout = '//layouts/club';
    public $_class = 'CommunityStatus';
    public $authItem = 'cook_choose';//     <------ Insert AuthItem here

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
