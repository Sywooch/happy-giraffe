<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 9/5/12
 * Time: 1:23 PM
 * To change this template use File | Settings | File Templates.
 */
class ServiceCategories extends BController
{
    public $defaultAction = 'admin';
    public $section = 'club';
    public $layout = '//layouts/club';
    public $_class = 'Service';
    public $authItem = 'services';

    public function actions()
    {
        return array(
            'create' => 'application.components.actions.Create',
            'update' => 'application.components.actions.Update',
            'delete' => 'application.components.actions.Delete',
            'admin' => 'application.components.actions.Admin',
        );
    }
}
