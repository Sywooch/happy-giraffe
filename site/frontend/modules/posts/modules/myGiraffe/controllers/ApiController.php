<?php
namespace site\frontend\modules\posts\modules\myGiraffe\controllers;

/**
 * @author Никита
 * @date 17/04/15
 */

class ApiController extends \site\frontend\components\api\ApiController
{
    public function actionTest()
    {
        $this->data = 123;
        $this->success = true;
    }
}