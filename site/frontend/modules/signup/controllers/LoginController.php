<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 24/02/14
 * Time: 17:02
 * To change this template use File | Settings | File Templates.
 */

class LoginController extends HController
{
    public function actions()
    {
        return array(
            'social' => array(
                'class' => 'signup.components.SocialAction',
                'successCallback' => function($eauth) {
                    $identity = new SocialUserIdentity($eauth);
                    if ($identity->authenticate()) {
                        Yii::app()->user->login($identity, 3600*24*30);
                        $eauth->redirect();
                    } else {
                        $eauth->component->setRedirectView('signup.views.redirect');
                        $eauth->redirect(null, array(
                            'attributes' => $eauth->getAttributes(),
                            'fromLogin' => true,
                        ));
                    }
                }
            ),
        );
    }

    public function actionDefault()
    {
        $model = new LoginForm();

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'loginForm')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['LoginForm']))
        {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
    }

//    public function actionSocial()
//    {
//        $serviceName = Yii::app()->request->getQuery('service');
//        if (isset($serviceName)) {
//            /** @var $eauth EAuthServiceBase */
//            $eauth = Yii::app()->eauth->getIdentity($serviceName);
//            $eauth->redirectUrl = Yii::app()->user->returnUrl;
//            $eauth->cancelUrl = $this->createAbsoluteUrl('site/login');
//
//            try {
//                if ($eauth->authenticate()) {
//                    $identity = new SocialUserIdentity($eauth);
//                    if ($identity->authenticate()) {
//                        Yii::app()->user->login($identity, 3600*24*30);
//                        $eauth->redirect();
//                    }
//                }
//
//                // Something went wrong, redirect back to login page
//                $this->redirect(array('site/login'));
//            }
//            catch (EAuthException $e) {
//                // save authentication error to session
//                Yii::app()->user->setFlash('error', 'EAuthException: '.$e->getMessage());
//
//                // close popup window and redirect to cancelUrl
//                $eauth->redirect($eauth->getCancelUrl());
//            }
//        }
//    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax']==='loginForm')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}