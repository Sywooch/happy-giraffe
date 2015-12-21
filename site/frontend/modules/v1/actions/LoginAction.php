<?php

namespace site\frontend\modules\v1\actions;

class LoginAction extends RoutedAction
{
    public function run()
    {
        $this->route(null, 'login', null, null);
    }

    public function login()
    {
        if (isset($_POST['service'])) {
            $this->socialLogin(\Yii::app()->request->getPost('service', null));
        } else {
            if ($this->controller->auth()) {
                $this->controller->data = \User::model()->findByPk($this->controller->identity->getId());
            }
        }
    }

    private function socialLogin($service) {
        $controller = $this->controller;

        if (isset($service)) {

        }
    }


    /*public function run()
    {
        $controller = $this->getController();

        $serviceName = Yii::app()->request->getQuery('service');
        if (isset($serviceName)) {
            /** @var $eauth EAuthServiceBase */
            $eauth = Yii::app()->eauth->getIdentity($serviceName);
            $eauth->redirectUrl = Yii::app()->user->returnUrl;
            $eauth->cancelUrl = $controller->createAbsoluteUrl('site/login');

            try {
                if ($eauth->authenticate()) {
                    //var_dump($eauth->getIsAuthenticated(), $eauth->getAttributes());
                    $identity = new EAuthUserIdentity($eauth);

                    // successful authentication
                    if ($identity->authenticate()) {
                        if (is_callable($this->successCallback))
                            call_user_func($this->successCallback, $eauth);
                    }
                    else {
                        // close popup window and redirect to cancelUrl
                        $eauth->cancel();
                    }
                }

                // Something went wrong, redirect to login page
                $controller->redirect(array('site/login'));
            }
            catch (EAuthException $e) {
                // save authentication error to session
                Yii::app()->user->setFlash('error', 'EAuthException: '.$e->getMessage());

                // close popup window and redirect to cancelUrl
                $eauth->redirect($eauth->getCancelUrl());
            }
        }
    }*/
}