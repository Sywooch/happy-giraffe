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
    
    /**
     * Специальные данные специалиста по сервису
     * @return string JSON
     * @author Sergey Gubarev
     */
    public function getSpecialistJSON() 
    {   
        $user = \Yii::app()->user->getModel();

        if (!$user->isSpecialistOfGroup(SpecialistGroup::DOCTORS))//хз где искать Enum, спросить у Никиты
        {
            throw new \CHttpException(403);
        }

        /*@var $specialistProfile SpecialistProfile */
        $specialistProfile = $user->specialistProfile;
        
        $response = [];
        
        if (!is_null($specialistProfile))
        {
            $response['authorizationIsDone'] = $specialistProfile->authorizationIsDone();

            $uploadPhotoTaskReletion = SpecialistGroupTaskRelation::model()->getByGroupAndTask(SpecialistGroup::DOCTORS, AuthorizationTypeEnum::UPLOAD_PHOTO);
            $pactTaskReletion = SpecialistGroupTaskRelation::model()->getByGroupAndTask(SpecialistGroup::DOCTORS, AuthorizationTypeEnum::APPROVE_PACT);

            $specialistPhotoUploadTask = SpecialistsProfileAuthorizationTasks::getByUserAndType($specialistProfile->id, $uploadPhotoTaskReletion->id);
            
            $response['photoUploadIsDone'] = is_null($specialistPhotoUploadTask) ? true : $specialistPhotoUploadTask->status == ProfileTasksStatusEnum::DONE;
        
            
            $specialistApprovePactTask = SpecialistsProfileAuthorizationTasks::getByUserAndType($specialistProfile->id, $pactTaskReletion->id);
            
            $pactIsDone = $specialistApprovePactTask->status == ProfileTasksStatusEnum::DONE;
            
            $response['pactIsDone'] = is_null($specialistApprovePactTask) ? true : $pactIsDone;
            
            
            $response['dateOfPactIsDone'] = $pactIsDone ? \Yii::app()->dateFormatter->format('dd MMMM yyyy', $specialistApprovePactTask->updated) : null;
        }
        
        return json_encode($response);
    }
    
    public function actionQuestions()
    {
        $user = \Yii::app()->user->getModel();

        if (!$user->isSpecialistOfGroup(1))//хз где искать Enum, спросить у Никиты
        {
            throw new \CHttpException(403);
        }

        $dp = QaManager::getQuestionsDp(\Yii::app()->user->id);
        
        $this->render('questions', compact('dp'));
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
        $form = new \ProfileForm();
        $form->initialize(\Yii::app()->user->id);
        $this->render('profile', compact('form'));
    }

    public function actionStats()
    {
        $this->render('stats');
    }

    public function actionRating($page = 1)
    {
        $this->render('rating', compact('page'));
    }
}