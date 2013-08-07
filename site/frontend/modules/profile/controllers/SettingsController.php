<?php

class SettingsController extends HController
{
    public $layout = 'settings';
    public $tempLayout = true;
    public $user;
    public $title = 'Мои настройки';

    public function accessRules()
    {
        return array(
            array('deny',
                'users' => array('?'),
            ),
        );
    }

    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CaptchaAction',
                'backColor' => 0xFFFFFF,
                'width' => 128,
                'height' => 45,
                'onlyDigits' => TRUE,
            ),
        );
    }

    public function beforeAction($action){
        $this->user = Yii::app()->user->getModel();

        return parent::beforeAction($action);
    }

    public function actionPersonal()
    {
        $this->render('personal');
    }

    public function actionSocial()
    {
        $this->render('social');
    }

    public function actionPassword()
    {
        $this->pageTitle = 'Мои настройки - Изменение пароля';
        $this->user->scenario = 'change_password';

        if (isset($_POST['User'])) {
            $this->user->attributes = $_POST['User'];
            if ($this->user->validate(array('current_password', 'new_password', 'new_password_repeat', 'verifyCode'))) {
                $this->user->password = $this->user->new_password;
                $this->user->save(true, array('password'));
                Yii::app()->user->setFlash('success', 1);
            }
        }

        $this->render('password', array(
            'user' => $this->user,
        ));
    }
}