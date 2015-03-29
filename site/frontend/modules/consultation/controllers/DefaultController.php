<?php
namespace site\frontend\modules\consultation\controllers;
use site\frontend\modules\consultation\models\Consultation;
use site\frontend\modules\consultation\models\ConsultationQuestion;
use site\frontend\modules\consultation\models\forms\AskForm;

/**
 * @author Никита
 * @date 20/03/15
 */

class DefaultController extends \LiteController
{
    public $layout = 'main';

    protected function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $cs = \Yii::app()->clientScript;
            $package = \Yii::app()->user->isGuest ? 'lite_consultation' : 'lite_consultation_user';
            $cs->registerPackage($package);
            $cs->useAMD = true;
            return true;
        }
    }

    public function actionIndex($consultationId)
    {

    }

    public function actionQuestion($questionId)
    {
        $question = ConsultationQuestion::model()->findByPk($questionId);
        $this->render('/question', compact('question'));
    }

    public function actionCreate($slug)
    {
        $consultation = $this->loadModel($slug);
        $model = new ConsultationQuestion();

        if (isset($_POST[\CHtml::modelName($model)])) {
            if (isset($_POST['ajax'])) {
                echo \CActiveForm::validate($model);
                \Yii::app()->end();
            }

            $model->attributes = $_POST[\CHtml::modelName($model)];
            $model->consultationId = $consultation->id;

            if ($model->save()) {
                $this->redirect($model->getUrl());
            }
        }

        $this->layout = '//layouts/lite/common';
        $this->render('/create', compact('model'));
    }

    protected function loadModel($slug)
    {
        $consultation = Consultation::model()->slug($slug)->find();
        if ($consultation === null) {
            throw new \CHttpException(404);
        }
        return $consultation;
    }
}