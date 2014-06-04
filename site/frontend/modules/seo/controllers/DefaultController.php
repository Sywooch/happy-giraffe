<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 04/06/14
 * Time: 16:48
 */

namespace site\frontend\modules\seo\controllers;


class DefaultController extends \HController
{
    public function actionTest()
    {
        \Yii::log('lolwhat', \CLogger::LEVEL_ERROR, 'seo');
    }
} 