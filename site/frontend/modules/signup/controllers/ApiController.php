<?php

namespace site\frontend\modules\signup\controllers;
use site\frontend\modules\signup\components\SafeUserIdentity;
use site\frontend\modules\signup\components\UserIdentity;
use site\frontend\modules\signup\models\CaptchaForm;
use site\frontend\modules\signup\models\LoginForm;
use site\frontend\modules\signup\models\PasswordRecoveryForm;
use site\frontend\modules\signup\models\RegisterForm;

/**
 * @author Никита
 * @date 12/12/14
 */

class ApiController extends \site\frontend\components\api\ApiController
{
    public function actionRegister(array $attributes)
    {
        if (\Yii::app()->db instanceof \DbConnectionMan) {
            // Отключим слейвы, чтобы UserIdentity нашла пользователя
            \Yii::app()->db->enableSlave = false;
        }

        $form = new RegisterForm();
        $form->attributes = $attributes;
        $this->success = $form->save();
        if ($this->success) {
            $identity = new UserIdentity($form->email, $form->password);
            if ($identity->authenticate()) {
                \Yii::app()->user->login($identity);
            }
            $returnUrl = (strpos(\Yii::app()->user->returnUrl, 'commentatorsContest') === false) ? $form->user->getUrl() : \Yii::app()->user->returnUrl;
            $this->data = array(
                'returnUrl' => $returnUrl,
            );
        } else {
            $this->data = array(
                'errors' => $form->user->getErrors(),
            );
        }
    }

    public function actionValidate(array $attributes)
    {
        $form = new RegisterForm();
        $form->attributes = $attributes;
        $form->validate();
        $this->success = true;
        $this->data = array(
            'errors' => $form->getErrors(),
        );
    }

    public function actionCaptcha(array $attributes)
    {
        $form = new CaptchaForm();
        $form->attributes = $attributes;
        $form->validate();
        $this->success = true;
        $this->data = array(
            'errors' => $form->getErrors(),
        );
    }

    public function actionLogin(array $attributes)
    {
        $form = new LoginForm();
        $form->attributes = $attributes;
        $this->success = $form->validate() && $form->login();
        $this->data = array(
            'errors' => $form->getErrors(),
            'returnUrl' => \Yii::app()->user->returnUrl,
        );
    }

    public function actionPasswordRecovery(array $attributes)
    {
        $form = new PasswordRecoveryForm();
        $form->attributes = $attributes;
        $this->success = $form->validate() && $form->send();
        $this->data = array(
            'errors' => $form->getErrors(),
        );
    }
} 