<?php
/**
 * @author Никита
 * @date 09/11/15
 */

namespace site\frontend\modules\som\modules\qa\controllers;


class ApiController extends \site\frontend\components\api\ApiController
{
    public function actionTest()
    {
        $this->success = true;
        $this->data = '123';
    }
}