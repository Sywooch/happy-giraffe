<?php
namespace site\frontend\modules\comments\modules\contest\controllers;
use site\frontend\modules\comments\modules\contest\components\ContestManager;

/**
 * @author Никита
 * @date 20/02/15
 */

class ApiController extends \site\frontend\components\api\ApiController
{
    public function actionRegister()
    {
        $this->success = ContestManager::register(\Yii::app()->user->id);
    }
}