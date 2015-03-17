<?php
/**
 * @author Никита
 * @date 13/03/15
 */

namespace site\frontend\modules\analytics\controllers;


use site\frontend\modules\analytics\components\VisitsManager;

class ApiController extends \site\frontend\components\api\ApiController
{
    public function actionProcessHit($url = null)
    {
        if ($url === null) {
            $url = \Yii::app()->request->getUrlReferrer();
        }
        \Yii::app()->getModule('analytics')->visitsManager->processVisit($url);
        $this->success = true;
        $this->data = $url;
    }
}