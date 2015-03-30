<?php
namespace site\frontend\modules\consultation\controllers;
use site\frontend\modules\consultation\models\Consultation;
use site\frontend\modules\consultation\models\ConsultationAnswer;
use site\frontend\modules\consultation\models\ConsultationQuestion;
use site\frontend\modules\consultation\models\forms\AskForm;

/**
 * @author Никита
 * @date 20/03/15
 */

class DefaultController extends \LiteController
{
    public $layout = 'main';

    public $consultation;

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
                'actions' => array('create'),
            ),
        );
    }

    protected function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $cs = \Yii::app()->clientScript;
            $package = \Yii::app()->user->isGuest ? 'lite_consultation' : 'lite_consultation_user';
            $cs->registerPackage($package);
            $cs->useAMD = true;
            return true;
        }
        return parent::beforeAction($action);
    }

    public function actionIndex($slug)
    {
        $this->consultation = $this->loadModel($slug);
        $dp = new \CActiveDataProvider('\site\frontend\modules\consultation\models\ConsultationQuestion', array(
            'criteria' => array(
                'scopes' => array(
                    'listView',
                    'orderDesc',
                    'consultation' => $this->consultation->id,
                ),
            ),
            'pagination' => array(
                'pageVar' => 'page',
            ),
        ));
        $this->render('index', compact('dp'));
    }

    public function actionQuestion($questionId)
    {
        $question = ConsultationQuestion::model()->with('consultation')->findByPk($questionId);
        if ($question === null) {
            throw new \CHttpException(404);
        }
        $this->consultation = $question->consultation;
        $this->render('question', compact('question'));
    }

    public function actionCreate($slug, $questionId = null)
    {
        $consultation = $this->loadModel($slug);
        if ($questionId === null) {
            $model = new ConsultationQuestion();
        } else {
            $model = ConsultationQuestion::model()->findByPk($questionId);
            if ($model === null) {
                throw new \CHttpException(404);
            }
        }

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

        $this->layout = 'form';
        $this->render('create', compact('model'));
    }

    public function actionAnswer($questionId)
    {
        $question = ConsultationQuestion::model()->findByPk($questionId);
        if ($question === null) {
            throw new \CHttpException(404);
        }
        $consultant = $question->consultation->getConsultantByUserId(\Yii::app()->user->id);
        if ($consultant === null) {
            throw new \CHttpException(403);
        }

        $model = ($question->answer === null) ? new ConsultationAnswer() : $question->answer;

        if (isset($_POST[\CHtml::modelName($model)])) {
            if (isset($_POST['ajax'])) {
                echo \CActiveForm::validate($model);
                \Yii::app()->end();
            }

            $model->attributes = $_POST[\CHtml::modelName($model)];
            $model->questionId = $questionId;
            $model->consultantId = $consultant->id;

            if ($model->save()) {
                $this->redirect($model->getUrl());
            }
        }

        $this->layout = 'form';
        $this->render('answer', compact('model'));
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