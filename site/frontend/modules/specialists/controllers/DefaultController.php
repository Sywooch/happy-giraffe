<?php
/**
 * @author Никита
 * @date 22/08/16
 */

namespace site\frontend\modules\specialists\controllers;


class DefaultController extends \LiteController
{
    public $litePackage = 'posts';

    public function actionIndex()
    {
        $this->render('index');
    }
}