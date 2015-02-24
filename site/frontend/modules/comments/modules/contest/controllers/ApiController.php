<?php
namespace site\frontend\modules\comments\modules\contest\controllers;
use site\frontend\modules\comments\modules\contest\components\ContestManager;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContest;

/**
 * @author Никита
 * @date 20/02/15
 */

class ApiController extends \site\frontend\components\api\ApiController
{
    public function actionRegister()
    {
        $contest = CommentatorsContest::model()->active()->find();
        if ($contest !== null) {
            $this->success = $contest->register(\Yii::app()->user->id);
        }
    }
}