<?php
/**
 * @author Никита
 * @date 23/08/16
 */

namespace site\frontend\modules\specialists\modules\pediatrician\controllers;


use site\frontend\modules\specialists\modules\pediatrician\components\QaManager;

class ApiController extends \site\frontend\components\api\ApiController
{
    public function actionSkip($questionId)
    {
        $this->success = QaManager::skip(\Yii::app()->user->id, $questionId);
    }
    
    public function actionGetNextLocation($questionId)
    {
        $this->success = true;
        $nextQuestion = QaManager::getNextQuestion($questionId, \Yii::app()->user->id);
        $goTo = ($nextQuestion) ? $this->createUrl('/specialists/pediatrician/default/answer', ['questionId' => $nextQuestion->id]) : $this->createUrl('/specialists/pediatrician/default/questions');
        $this->data = [
            'href' => $goTo,
        ];
    }
}