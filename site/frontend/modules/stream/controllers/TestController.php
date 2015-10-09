<?php

namespace site\frontend\modules\stream\controllers;

use site\frontend\modules\stream\models\Stream;
use site\frontend\components\api\ApiController;

class TestController extends \CController
{
    public function actionIndex()
    {
        $data = 'SomeTestDataFromIndexAction';
        \Yii::app()->nginxStream->send('talk?id=wed', $data);
        return 'test';
    }

    public function actionTest()
    {
        //var_dump(\Yii::app()->request);
        $channel = \Yii::app()->request->getPost('channel');
        $data = \Yii::app()->request->getPost('text');
        \Yii::app()->nginxStream->send($channel, $data);
        return 'test';
    }
}