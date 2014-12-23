<?php

namespace site\frontend\modules\signup\controllers;
/**
 * @author Никита
 * @date 23/12/14
 */



class DefaultController extends \HController
{
    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'RegisterCaptchaAction',
                'mode' => \CaptchaExtendedAction::MODE_WORDS,
                'testLimit' => 0,
            ),
            'social' => array(
                'class' => 'signup.components.SignupSocialAction',
                'fromLogin' => false,
            ),
        );
    }
} 