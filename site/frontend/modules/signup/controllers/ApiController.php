<?php

namespace site\frontend\modules\signup\controllers;
use site\frontend\modules\signup\models\RegisterForm;

/**
 * @author Никита
 * @date 12/12/14
 */

class ApiController extends \site\frontend\components\api\ApiController
{
    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'RegisterCaptchaAction',
                'mode' => \CaptchaExtendedAction::MODE_WORDS,
                'testLimit' => 0,
            ),
        );
    }

    public function actionRegister(array $attributes)
    {
        $form = new RegisterForm();
        $form->attributes = $attributes;
        $this->success = $form->save();
        $this->data = array(
            'errors' => $form->getErrors(),
        );
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
} 