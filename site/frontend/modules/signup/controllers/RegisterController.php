<?php
/**
 * Реализует функционал регистрации пользователя на сайте
 */

class RegisterController extends HController
{
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
                'actions' => array('clubs', 'family'),
            ),
        );
    }

    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'RegisterCaptchaAction',
                'mode' => CaptchaExtendedAction::MODE_WORDS,
                'testLimit' => 0,
            ),
            'captcha2' => array(
                'class' => 'RegisterCaptchaAction',
                'mode' => CaptchaExtendedAction::MODE_WORDS,
                'testLimit' => 0,
            ),
            'social' => array(
                'class' => 'signup.components.SignupSocialAction',
                'fromLogin' => false,
            ),
        );
    }

    /**
     * 1 шаг регистрации
     */
    public function actionStep1()
    {
        $model = new RegisterFormStep1();

        $this->performAjaxValidation($model);

        if (isset($_POST['RegisterFormStep1'])) {
            $model->attributes = $_POST['RegisterFormStep1'];
            $success = $model->validate() && $model->save();
            $response = compact('success');
            if ($success)
                $response['id'] = $model->user->id;
            echo CJSON::encode($response);
        }
    }

    /**
     * 2 шаг регистрации
     */
    public function actionStep2()
    {
        $userId = Yii::app()->request->getPost('userId');
        $social = Yii::app()->request->getPost('social');
        $model = new RegisterFormStep2();
        $model->user = ($userId) ? User::model()->findByPk($userId) : new User();
        if ($social == 'true')
            $model->scenario = 'social';

        $this->performAjaxValidation($model);

        if (isset($_POST['RegisterFormStep2'])) {
            $model->attributes = $_POST['RegisterFormStep2'];
            $success = $model->validate() && $model->save();
            $response = compact('success');
            if ($success)
                $response['id'] = $model->user->id;
            echo CJSON::encode($response);
        }
    }

    /**
     * 3 шаг регистрации - клубы
     */
    public function actionClubs()
    {
        $this->layout = '//layouts/new/common';
        $this->pageTitle = 'Выберите клубы';
        $this->render('clubs');
    }

    /**
     * 4 шаг регистрации - семья
     */
    public function actionFamily()
    {
        $this->layout = '//layouts/new/common';
        $json = Yii::app()->user->model->getFamilyData();
        $nextUrl = Yii::app()->user->getReturnUrl($this->createUrl('/profile/default/index', array('user_id' => Yii::app()->user->id)));
        $json['callback'] = 'window.location.href = \'' . $nextUrl . '\';';
        $this->pageTitle = 'Заполните семью';
        $this->render('family', compact('json', 'nextUrl'));
    }

    /**
     * Подтверждение e-mail
     * @param $activationCode
     */
    public function actionConfirm($activationCode, $url = '/')
    {
        $identity = new ActivationUserIdentity($activationCode);
        if ($identity->authenticate()) {
            Yii::app()->user->login($identity);
            $this->redirect(array('/signup/register/clubs/'));
        } elseif ($identity->errorCode == ActivationUserIdentity::ERROR_CODE_USED)
            $this->redirect($url);
        else
            echo $identity->errorMessage;
    }

    /**
     * Повторная отправка письма с кодом активации и паролем
     */
    public function actionResend()
    {
        $model = new ResendConfirmForm();

        $this->performAjaxValidation($model);

        if (isset($_POST['ResendConfirmForm'])) {
            $model->attributes = $_POST['ResendConfirmForm'];
            $success = $model->validate() && $model->send();
            echo CJSON::encode(compact('success'));
        }
    }

    /**
     * Загрузка изображения на аватар
     */
    public function actionAvatarUpload()
    {
        $model = new AvatarUploadForm();
        $model->image = CUploadedFile::getInstance($model, 'image');
        $response = array();
        $success = $model->validate() && $model->upload();
        $response['success'] = $success;
        if ($success)
            $response['imgSrc'] = $model->getFileName();
        echo CJSON::encode($response);
    }

    /**
     * Ajax-валидация
     * @param $model
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && in_array($_POST['ajax'], array('registerFormStep1', 'registerFormStep2', 'registerSocial', 'resendConfirmForm')))
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}