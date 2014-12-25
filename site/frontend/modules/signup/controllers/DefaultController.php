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
                'class' => 'site\frontend\modules\signup\components\RegisterCaptchaAction',
                'mode' => \CaptchaExtendedAction::MODE_WORDS,
                'testLimit' => 0,
            ),
            'socialRegister' => array(
                'class' => 'site\frontend\modules\signup\components\SignupSocialAction',
                'fromLogin' => false,
            ),
            'socialLogin' => array(
                'class' => 'site\frontend\modules\signup\components\SignupSocialAction',
                'fromLogin' => true,
            ),
        );
    }

    public function actionTest()
    {
        var_dump(\Yii::app()->user->getState('socialService'));
    }
} 