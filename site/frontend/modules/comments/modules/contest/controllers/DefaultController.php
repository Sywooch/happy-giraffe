<?php
/**
 * @author Никита
 * @date 26/02/15
 */

namespace site\frontend\modules\comments\modules\contest\controllers;


class DefaultController extends \LiteController
{
    public $layout = '//layouts/lite/common';
    public $litePackage = 'contest_commentator';
    public $bodyClass = 'body__contest-commentator';

    public function actionIndex()
    {
        $this->render('/index');
    }
}