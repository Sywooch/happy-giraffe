<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 10/24/12
 * Time: 2:37 PM
 * To change this template use File | Settings | File Templates.
 */
class CommunityBannersController extends BController
{
    public $defaultAction = 'admin';
    public $section = 'club';
    public $layout = '//layouts/club';
    public $_class = 'CommunityBanner';
    public $authItem = 'cook_choose';

    public function actions()
    {
        return array(
            'create' => 'application.components.actions.Create',
            'update' => 'application.components.actions.Update',
            'admin' => 'application.components.actions.Admin',
            'addPhoto' => 'application.components.actions.UploadPhoto'
        );
    }

    public function onCreateBeforeRender($vars)
    {
        if (($content_id = Yii::app()->request->getQuery('content_id')) === null)
            throw new CHttpException(404);

        $vars['model']->content_id = $content_id;
        $vars['model']->title = $vars['model']->content->title;
    }
}
