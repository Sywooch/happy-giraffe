<?php

class DefaultController extends HController
{
    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CaptchaExtendedAction',
                'mode' => CaptchaExtendedAction::MODE_WORDS,
            ),
            'social' => array(
                'class' => 'signup.components.SocialAction',
                'successCallback' => function($eauth) {
                    $eauth->component->setRedirectView('signup.views.redirect');
                    $eauth->redirect(null, array(
                        'attributes' => $eauth->getAttributes(),
                        'fromLogin' => false,
                    ));
                }
            ),
        );
    }

    public function actionTest2()
    {
        $this->render('test2');
    }

    public function actionReg()
    {
        $step = Yii::app()->request->getPost('step');
        $social = Yii::app()->request->getPost('social');
        $userId = Yii::app()->request->getPost('userId');
        $scenario = ($step == RegisterWidget::STEP_REG1) ? 'signupStep1' : (($social == 'true') ? 'signupStep2Social' : 'signupStep2');
        $model = empty($userId) ? new User() : User::model()->findByPk($userId);
        $model->setScenario($scenario);
        $model->attributes = $_POST['User'];
        $this->performAjaxValidation($model);
        $response = array();
        if ($step == RegisterWidget::STEP_REG1) {
            $model->registration_finished = 0;
            $success = $model->save();
            $response['success'] = $success;
            if ($success)
                $response['id'] = $model->id;
        } else {
            $success = $model->save();
            $response['success'] = $success;
            if ($success)
                $model->register();
        }
        echo CJSON::encode($response);
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax']==='registerForm')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionFinish()
    {
        $model = new User();
        $model->attributes = $_POST['User'];
        $success = $model->save(false);
        if ($success)
            $model->register();

        echo CJSON::encode(compact('success'));
    }
}