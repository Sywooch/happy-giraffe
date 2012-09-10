<?php

class CommunityRubricController extends BController
{
    public $defaultAction = 'admin';
    public $_class = 'CommunityRubric';
    public $authItem = 'administrator';//     <------ Insert AuthItem here

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
