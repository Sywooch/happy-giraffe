<?php
/**
 * @author Никита
 * @date 27/10/15
 */

namespace site\frontend\modules\posts\modules\forums\controllers;


class DefaultController extends \LiteController
{
    public $litePackage = 'forum-homepage';

    public function actionIndex()
    {
        $this->render('index');
    }
}