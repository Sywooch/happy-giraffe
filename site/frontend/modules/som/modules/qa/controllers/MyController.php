<?php
/**
 * @author Никита
 * @date 18/11/15
 */

namespace site\frontend\modules\som\modules\qa\controllers;


use site\frontend\modules\som\modules\qa\components\QaController;
use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaAnswerVote;
use site\frontend\modules\som\modules\qa\models\QaQuestion;

class MyController extends QaController
{
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'users' => array('?'),
            ),
        );
    }

    public $layout = '/layouts/my';

    public function actionQuestions($categoryId = null)
    {
        $model = clone QaQuestion::model();
        $model->user(\Yii::app()->user->id)->orderDesc()->apiWith('user');
        if ($categoryId !== null) {
            $model->category($categoryId);
        }
        $dp = new \CActiveDataProvider($model, array(
            'pagination' => array(
                'pageVar' => 'page',
            ),
        ));
        $this->render('questions', compact('dp'));
    }

    public function actionAnswers($categoryId = null)
    {
        $model = clone QaAnswer::model();
        $model->user(\Yii::app()->user->id)->orderDesc()->with('question')->apiWith('user');
        if ($categoryId !== null) {
            $model->category($categoryId);
        }
        $dp = new \CActiveDataProvider($model, array(
            'pagination' => array(
                'pageVar' => 'page',
            ),
        ));
        $this->render('answers', compact('dp'));
    }
}