<?php

class ProfileController extends HController
{
    /**
     * @var User
     */
    public $user;

    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CaptchaAction',
                'backColor' => 0xFFFFFF,
                'width' => 125,
                'height' => 46,
                'onlyDigits' => TRUE,
            ),
        );
    }

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

    public $layout = '//layouts/profile';

    protected function beforeAction($action)
    {
        $this->pageTitle = 'Мои настройки';

        $this->user = User::model()->findByPk(Yii::app()->user->id);
        return true;
    }

    public function actionIndex()
    {
        if (isset($_POST['User'])) {
            $this->user->attributes = $_POST['User'];
            $this->user->save(true, array('last_name', 'first_name', 'gender', 'email', 'birthday'));
        }

        $this->render('data', array());
    }

    public function actionAccess()
    {
        if (isset($_POST['User'])) {
            $this->user->attributes = $_POST['User'];
            $this->user->save(true, array('profile_access', 'guestbook_access', 'im_access'));
        }

        $this->render('access');
    }

    public function actionBlacklist()
    {
        $this->render('blacklist');
    }

    public function actionSubscription()
    {
        $this->render('subscription');
    }

    public function actionSocials()
    {
        $this->render('socials');
    }

    public function actionPassword()
    {
        $this->user->scenario = 'change_password';

        if (isset($_POST['User'])) {
            $this->user->attributes = $_POST['User'];
            if ($this->user->validate(array('current_password', 'new_password', 'new_password_repeat', 'verifyCode'))) {
                $this->user->password = $this->user->new_password;
                $this->user->save(true, array('password'));
            }
        }

        $this->render('password', array(
            'user' => $this->user,
        ));
    }

    public function actionRemove()
    {
        $this->user->deleted = 1;
        $this->user->save();
        Yii::app()->user->logout();
        $this->redirect('/');
    }

    /**
     * @param int $id model id
     * @return User
     * @throws CHttpException
     */
    public function loadUser($id)
    {
        $model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }

    public function actionDisableSocialService($name)
    {
        $check = UserSocialService::model()->findByUser($name, Yii::app()->user->id);
        if ($check)
            $check->delete();
        $this->redirect($_SERVER['HTTP_REFERER']);
    }
}