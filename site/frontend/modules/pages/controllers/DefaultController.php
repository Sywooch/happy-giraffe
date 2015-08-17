<?php
namespace site\frontend\modules\pages\controllers;

/**
 * @author Никита
 * @date 23/03/15
 */

class DefaultController extends \LiteController
{
    public $litePackage = 'info';
    public $layout = '/layout';
    public $bodyClass = 'body__regular';

    public function actions()
    {
        return array(
            'page' => array(
                'class' => 'CViewAction',
                'basePath' => 'site.frontend.modules.pages.views',
            ),
        );
    }

    public function actionTest()
    {
        $this->render('/about');
    }
}