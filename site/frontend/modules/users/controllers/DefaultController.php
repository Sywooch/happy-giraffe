<?php
/**
 * @author Никита
 * @date 13/01/15
 */

namespace site\frontend\modules\users\controllers;


class DefaultController extends \LiteController
{
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

    public $litePackage = 'member';

    public function actionSettings()
    {
        $this->render('settings');
    }
} 