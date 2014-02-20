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

	public function actionTest()
	{
		$this->render('test');
	}

    public function actionTest2()
    {
        $this->render('test2');
    }

    public function actionValidation()
    {
        print_r($_POST);
        die;

        $model = new User('signup');
        $model->attributes = $_POST['User'];
        if(isset($_POST['ajax']) && $_POST['ajax']==='registerForm')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionLogin() {
        $serviceName = Yii::app()->request->getQuery('service');
        if (isset($serviceName)) {
            /** @var $eauth EAuthServiceBase */
            $eauth = Yii::app()->eauth->getIdentity($serviceName);
            $eauth->redirectUrl = Yii::app()->user->returnUrl;
            $eauth->cancelUrl = $this->createAbsoluteUrl('site/login');

            try {
                if ($eauth->authenticate()) {
                    header('Content-Type: text/html; charset=utf-8');
                    var_dump($eauth->getIsAuthenticated(), $eauth->getAttributes());
                    die;
                    $identity = new EAuthUserIdentity($eauth);

                    // successful authentication
                    if ($identity->authenticate()) {
                        Yii::app()->user->login($identity);
                        //var_dump($identity->id, $identity->name, Yii::app()->user->id);exit;

                        // special redirect with closing popup window
                        $eauth->redirect();
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