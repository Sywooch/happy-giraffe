<?php

class DefaultController extends HController
{
    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CaptchaExtendedAction',
                'width' => 128,
                'height' => 45,
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
        $userId = Yii::app()->request->getPost('userId');
        $scenario = ($step == RegisterWidget::STEP_REG1) ? 'signupStep1' : 'signupStep2';
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

    public function actionSocial()
    {
        $serviceName = Yii::app()->request->getQuery('service');
        if (isset($serviceName)) {
            /** @var $eauth EAuthServiceBase */
            $eauth = Yii::app()->eauth->getIdentity($serviceName);
            $eauth->redirectUrl = Yii::app()->user->returnUrl;
            $eauth->cancelUrl = $this->createAbsoluteUrl('site/login');

            try {
                if ($eauth->authenticate()) {
                    //var_dump($eauth->getIsAuthenticated(), $eauth->getAttributes());
                    $identity = new EAuthUserIdentity($eauth);

                    // successful authentication
                    if ($identity->authenticate()) {
                        $eauth->component->setRedirectView('signup.views.redirect');

                        // special redirect with closing popup window
                        $eauth->redirect(null, array('attributes' => $eauth->getAttributes()));
                    }
                    else {
                        // close popup window and redirect to cancelUrl
                        $eauth->cancel();
                    }
                }

                // Something went wrong, redirect to login page
                $this->redirect(array('site/login'));
            }
            catch (EAuthException $e) {
                // save authentication error to session
                Yii::app()->user->setFlash('error', 'EAuthException: '.$e->getMessage());

                // close popup window and redirect to cancelUrl
                $eauth->redirect($eauth->getCancelUrl());
            }
        }

        // default authorization code through login/password ..
    }
}