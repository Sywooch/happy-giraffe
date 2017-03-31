<?php
/**
 * @author Никита
 * @date 18/11/15
 */

use site\frontend\modules\iframe\components\QaController;
use site\frontend\modules\iframe\models\QaAnswer;
use site\frontend\modules\iframe\models\QaAnswerVote;
use site\frontend\modules\iframe\models\QaQuestion;
use site\frontend\modules\iframe\models\QaCTAnswer;

class MyController extends QaController
{

    public $litePackage = 'pediatrician-iframe';

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
                'pageSize' => 4,
            ),
        ));

        $this->render('content', compact('dp', 'categoryId'));
    }

    public function actionAnswers($categoryId = null)
    {
        $model = clone QaAnswer::model();
        $model->checkQuestionExiststance()->user(\Yii::app()->user->id)->orderDesc()->apiWith('user');

        $dp = new \CActiveDataProvider($model, array(
            'pagination' => array(
                'pageVar' => 'page',
                'pageSize' => 10,
            ),
        ));
        $this->render('content', compact('dp', 'categoryId'));
    }
}