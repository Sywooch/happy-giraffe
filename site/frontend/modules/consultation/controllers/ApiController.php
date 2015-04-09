<?php
/**
 * @author Никита
 * @date 30/03/15
 */

namespace site\frontend\modules\consultation\controllers;


class ApiController extends \site\frontend\components\api\ApiController
{
    public function actionRemove($questionId)
    {
        $question = $this->getModel('site\frontend\modules\consultation\models\ConsultationQuestion', $questionId);
        if (! \Yii::app()->user->checkAccess('removeQuestions', array('consultation' => $question->consultation))) {
            throw new \CHttpException(403);
        }

        $this->success = $question->softDelete();
    }
}