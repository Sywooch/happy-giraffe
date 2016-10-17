<?php

namespace site\frontend\modules\specialists\modules\pediatrician\controllers;
use site\frontend\modules\som\modules\qa\models\QaQuestion;
use site\frontend\modules\specialists\components\SpecialistsManager;
use site\frontend\modules\specialists\models\ProfileForm;
use site\frontend\modules\specialists\models\SpecialistGroup;
use site\frontend\modules\specialists\modules\pediatrician\components\QaManager;
use site\frontend\modules\specialists\models\SpecialistProfile;
use site\frontend\modules\specialists\models\SpecialistsProfileAuthorizationTasks;
use site\frontend\modules\specialists\models\specialistsAuthorizationTasks\AuthorizationTypeEnum;
use site\frontend\modules\specialists\models\specialistsProfileAuthorizationTasks\ProfileTasksStatusEnum;
use site\frontend\modules\specialists\models\SpecialistGroupTaskRelation;

/**
 * @author Никита
 * @date 16/08/16
 */
class DefaultController extends \LiteController
{
    public $layout = '/layouts/main';
    public $litePackage = 'pediatrician';

    /**
     * {@inheritDoc}
     * @see LiteController::filters()
     */
    public function filters()
    {
        return ['accessControl'];
    }

    /**
     * {@inheritDoc}
     * @see CController::accessRules()
     */
    public function accessRules()
    {
        return [
            [
                'allow',
                'actions'   => ['register'],
                'users'     => ['*']
            ],
            [
                'allow',
                'roles' => ['specialist']
            ],
            [
                'deny',
                'users' => ['*']
            ]
        ];
    }

    public function actionQuestions()
    {
        $user = \Yii::app()->user->getModel();

        if (!$user->isSpecialistOfGroup(SpecialistGroup::DOCTORS))//хз где искать Enum, спросить у Никиты
        {
            throw new \CHttpException(403);
        }

        /*@var $specialistProfile SpecialistProfile */
        $specialistProfile = $user->specialistProfile;

        $result = [];

        if (!is_null($specialistProfile))
        {
            $uploadPhotoTaskReletion = SpecialistGroupTaskRelation::model()->getByGroupAndTask(SpecialistGroup::DOCTORS, AuthorizationTypeEnum::UPLOAD_PHOTO);
            $pactTaskReletion = SpecialistGroupTaskRelation::model()->getByGroupAndTask(SpecialistGroup::DOCTORS, AuthorizationTypeEnum::APPROVE_PACT);

            $result['authorizationIsDone'] = $specialistProfile->authorizationIsDone();

            $specialistPhotoUploadTask = SpecialistsProfileAuthorizationTasks::getByUserAndType($specialistProfile->id, $uploadPhotoTaskReletion->id);
            $result['photoUploadIsDone'] = is_null($specialistPhotoUploadTask) ? true : $specialistPhotoUploadTask->status == ProfileTasksStatusEnum::DONE;

            $specialistApprovePactTask = SpecialistsProfileAuthorizationTasks::getByUserAndType($specialistProfile->id, $pactTaskReletion->id);
            $result['pactIsDone'] = is_null($specialistApprovePactTask) ? true : $specialistApprovePactTask->status == ProfileTasksStatusEnum::DONE;
        }

        $result['dp'] = QaManager::getQuestionsDp(\Yii::app()->user->id);
        $this->render('questions', $result);
    }

    public function actionAnswers()
    {
        $dp = QaManager::getAnswersDp(\Yii::app()->user->id);
        $this->render('answers', compact('dp'));
    }

    public function actionAnswer($questionId)
    {
        $question = QaQuestion::model()->findByPk($questionId);

        if (! $question) {
            throw new \CHttpException(404);
        }

        if (!$question->checkAccessForSpecialist())
        {
            $this->render('accessDenied', compact('question'));
        }

        $this->render('answer', compact('question'));
    }

    public function actionRegister()
    {
        $specs = SpecialistsManager::getSpecializations(SpecialistGroup::DOCTORS);
        $this->layout = '/layouts/register';
        $this->render('register', compact('specs'));
    }

    public function actionProfile()
    {
        $form = new ProfileForm();
        $form->initialize(\Yii::app()->user->id);
        $this->render('profile', compact('form'));
    }
}