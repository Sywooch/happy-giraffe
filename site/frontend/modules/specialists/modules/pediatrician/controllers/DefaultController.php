<?php

namespace site\frontend\modules\specialists\modules\pediatrician\controllers;
use site\frontend\modules\som\modules\qa\models\QaQuestion;
use site\frontend\modules\specialists\components\SpecialistsManager;
use site\frontend\modules\specialists\models\ProfileForm;
use site\frontend\modules\specialists\models\SpecialistGroup;
use site\frontend\modules\specialists\models\SpecialistProfile;
use site\frontend\modules\specialists\models\SpecialistSpecialization;
use site\frontend\modules\specialists\modules\pediatrician\components\QaManager;
use site\frontend\modules\specialists\modules\pediatrician\components\StatsManager;

/**
 * @author Никита
 * @date 16/08/16
 */
class DefaultController extends \LiteController
{
    public $layout = '/layouts/main';
    public $litePackage = 'pediatrician';

    public function accessRules()
    {
        return array(
            array('allow',
                'roles' => array('specialist'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionQuestions()
    {
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
        $this->render('answer', compact('question'));
    }
    
    public function actionRegister()
    {
        $specs = SpecialistsManager::getSpecializations(SpecialistGroup::PEDIATRICIAN);
        $this->layout = '/layouts/register';
        $this->render('register', compact('specs'));
    }

    public function actionProfile()
    {
        $form = new ProfileForm();
        $form->initialize(\Yii::app()->user->id);
        $this->render('profile', compact('form'));
    }

    public function actionStats()
    {
        $this->render('stats');
    }
}