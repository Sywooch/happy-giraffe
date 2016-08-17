<?php

namespace site\frontend\modules\specialists\modules\pediatrician\controllers;
use site\frontend\modules\specialists\modules\pediatrician\components\QaManager;

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
            array('deny',
                'users' => array('?'),
            ),
        );
    }

    public function actionQuestions()
    {
        $dp = QaManager::getQuestionsDp();
        $this->render('questions', compact('dp'));
    }
    
    public function actionAnswers()
    {
        $dp = QaManager::getAnswersDp(\Yii::app()->user->id);
        $this->render('answers', compact('dp'));
    }
}