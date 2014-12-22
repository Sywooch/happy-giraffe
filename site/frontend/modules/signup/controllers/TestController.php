<?php
/**
 * @author Никита
 * @date 22/12/14
 */

namespace site\frontend\modules\signup\controllers;


class TestController extends \LiteController
{
    public $litePackage = 'posts';

    public function actionReg()
    {
        $this->render('reg');
    }
} 