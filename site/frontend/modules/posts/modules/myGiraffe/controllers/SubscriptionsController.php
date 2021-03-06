<?php
/**
 * @author Никита
 * @date 22/04/15
 */

namespace site\frontend\modules\posts\modules\myGiraffe\controllers;


class SubscriptionsController extends \LiteController
{
    public $litePackage = 'member';
    public $layout = '//layouts/lite/common';

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'users' => array('?'),
            ),
        );
    }

    public function actionIndex()
    {
        $this->render('index');
    }
}