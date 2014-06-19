<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 19/06/14
 * Time: 14:50
 */

namespace site\frontend\modules\photo\controllers;


class TestController extends \HController
{
    public function actionUpload()
    {
        $this->render('upload');
    }
} 