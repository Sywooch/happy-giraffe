<?php

namespace site\frontend\modules\stream\controllers;

use site\frontend\modules\stream\models\Stream;
use site\frontend\components\api\ApiController;

class CollectionsApiController extends ApiController
{
    public function actionTest()
    {
        \Yii::log('Test action start.', 'info', 'stream.controller.TestController');
        //Какой-то код.
        $data = 'SomeTestData';
        Yii::app()->nginxStream->send('talk', $data);
    }
}