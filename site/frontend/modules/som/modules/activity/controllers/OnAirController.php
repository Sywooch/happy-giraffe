<?php
/**
 * @author Никита
 * @date 14/07/15
 */

namespace site\frontend\modules\som\modules\activity\controllers;


class OnAirController extends \LiteController
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

    public $litePackage = 'posts';

    public function actionIndex()
    {
        $this->render('index');
    }
}