<?php
/**
 * @author Никита
 * @date 23/08/16
 */

namespace site\frontend\modules\specialists\modules\pediatrician\controllers;


use site\frontend\modules\specialists\modules\pediatrician\components\QaManager;
use site\frontend\modules\specialists\models\SpecialistGroupTaskRelation;
use site\frontend\modules\specialists\models\specialistsAuthorizationTasks\AuthorizationTypeEnum;
use site\frontend\modules\specialists\models\SpecialistsProfileAuthorizationTasks;
use site\frontend\modules\specialists\models\SpecialistGroup;

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

    public function actionApprovePhotoUpload()
    {
        $user = \Yii::app()->user->getModel();

        if (!$user->isSpecialistOfGroup(SpecialistGroup::DOCTORS))
        {
            throw new \CHttpException(403);
        }

        /*@var $specialistProfile SpecialistProfile */
        $specialistProfile = $user->specialistProfile;

        $this->success = false;

        if (!is_null($specialistProfile))
        {
            $pactPhotoUploadReletion = SpecialistGroupTaskRelation::model()->getByGroupAndTask(SpecialistGroup::DOCTORS, AuthorizationTypeEnum::UPLOAD_PHOTO);
            $specialistApprovePhotoUploadTask = SpecialistsProfileAuthorizationTasks::getByUserAndType($specialistProfile->id, $pactPhotoUploadReletion->id);

            $this->success = $specialistApprovePhotoUploadTask->setStatusDone();
        }
    }

    public function actionApprovePact()
    {

        $user = \Yii::app()->user->getModel();

        if (!$user->isSpecialistOfGroup(SpecialistGroup::DOCTORS))
        {
            throw new \CHttpException(403);
        }

        /*@var $specialistProfile SpecialistProfile */
        $specialistProfile = $user->specialistProfile;

        $this->success = false;

        if (!is_null($specialistProfile))
        {
            $pactTaskReletion = SpecialistGroupTaskRelation::model()->getByGroupAndTask(SpecialistGroup::DOCTORS, AuthorizationTypeEnum::APPROVE_PACT);
            $specialistApprovePactTask = SpecialistsProfileAuthorizationTasks::getByUserAndType($specialistProfile->id, $pactTaskReletion->id);

            $this->success = $specialistApprovePactTask->setStatusDone();

            $this->data['date'] = \Yii::app()->dateFormatter->format('dd MMMM yyyy', time());
        }
    }

}