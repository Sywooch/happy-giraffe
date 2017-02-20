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
use site\frontend\modules\som\modules\qa\models\QaCTAnswer;

class MyController extends QaController
{

    public $litePackage = 'new_pediatrician';

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

    public $layout = '/layouts/new_my';

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
                'pageSize' => 4,
            ),
        ));

        $this->render('content', compact('dp', 'categoryId'));
    }

    public function actionAnswers($categoryId = null)
    {
        $model = clone QaAnswer::model();
        $model->user(\Yii::app()->user->id)->orderDesc()->apiWith('user');

        $dp = new \CActiveDataProvider($model, array(
            'pagination' => array(
                'pageVar' => 'page',
                'pageSize' => 10,
            ),
        ));
        $this->render('content', compact('dp', 'categoryId'));
    }
}