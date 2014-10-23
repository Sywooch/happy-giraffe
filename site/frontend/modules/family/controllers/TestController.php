<?php
/**
 * @author Никита
 * @date 23/10/14
 */

namespace site\frontend\modules\family\controllers;


class TestController extends \HController
{
    public function actionFamily()
    {
        \Yii::app()->user->model->getFamily();
    }
} 