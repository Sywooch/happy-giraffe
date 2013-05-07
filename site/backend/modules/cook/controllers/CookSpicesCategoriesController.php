<?php

class CookSpicesCategoriesController extends BController
{
    public $defaultAction = 'admin';
    public $section = 'club';
    public $layout = '//layouts/club';
    public $_class = 'CookSpiceCategory';
    public $authItem = 'cook_spices';

    public function actions()
    {
        return array(
            'update' => 'application.components.actions.Update',
            'admin' => 'application.components.actions.Admin',
            'addPhoto' => 'application.components.actions.UploadPhoto'
        );
    }
}
