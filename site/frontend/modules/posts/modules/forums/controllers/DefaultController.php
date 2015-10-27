<?php
/**
 * @author Никита
 * @date 27/10/15
 */

namespace site\frontend\modules\posts\modules\forums\controllers;


class DefaultController extends \LiteController
{
    public $litePackage = 'posts';

    public function actionIndex()
    {
        $this->render('index');
    }
}