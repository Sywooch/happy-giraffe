<?php
/**
 * Class RegisterController
 * Реализует функционал регистрации пользователя на сайте
 */

class RegisterController extends HController
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
                        'serviceName' => $eauth->getServiceName(),
                        'fromLogin' => false,
                    ));
                }
            ),
        );
    }

    /**
     * Контроллер для тестов
     * @todo Убрать
     */
    public function actionTest2()
    {
        $this->render('test2');
    }

    /**
     * 1 шаг регистрации
     */
    public function actionStep1()
    {
        $model = new RegisterFormStep1('signupStep1');

        $this->performAjaxValidation($model);

        if (isset($_POST['RegisterFormStep1'])) {
            $model->attributes = $_POST['RegisterFormStep1'];
            $success = $model->save();
            $response = array();
            $response['success'] = $success;
            if ($success)
                $response['id'] = $model->id;
            echo CJSON::encode($response);
        }
    }

    /**
     * 2 шаг регистрации
     * @todo Перенести бизнес-логику в модель
     */
    public function actionStep2()
    {
        $userId = Yii::app()->request->getPost('userId');
        $social = Yii::app()->request->getPost('social');
        $scenario = ($social == 'true') ? 'signupStep2Social' : 'signupStep2';
        $model = empty($userId) ? new RegisterFormStep2() : RegisterFormStep2::model()->findByPk($userId);
        $model->scenario = $scenario;

        $this->performAjaxValidation($model);

        $model->attributes = $_POST['RegisterFormStep2'];
        if ($social) {
            $socialService = new UserSocialService();
            $socialService->attributes = $_POST['UserSocialService'];
            $model->userSocialServices = array($socialService);
        }
        $success = $model->withRelated->save(true, array('userSocialServices')) && $model->register();
        $response['success'] = $success;
        if ($success)
            $response['id'] = $model->id;
        echo CJSON::encode($response);
    }

    /**
     * Подтверждение e-mail
     * @param $activationCode
     */
    public function actionConfirm($activationCode)
    {
        $identity = new ActivationUserIdentity($activationCode);
        if ($identity->authenticate()) {
            Yii::app()->user->login($identity, 3600*24*30);
            $this->redirect(array('/profile/default/signup/'));
        } else
            echo $identity->errorCode;
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

    public function actionAvatarUpload()
    {
        $model = new AvatarUploadForm();
        $model->image = CUploadedFile::getInstance($model, 'image');
        $success = $model->upload();
        echo CJSON::encode($success);
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