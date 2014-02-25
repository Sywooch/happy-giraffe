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

        $this->performAjaxValidation($model);

        if (isset($_POST['LoginForm']))
        {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'loginForm')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}