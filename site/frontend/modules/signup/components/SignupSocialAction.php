<?php

namespace site\frontend\modules\signup\components;

/**
 * Действие контроллера, обрабатывающая аутентификацию через социальные сети
 */

class SignupSocialAction extends \SocialAction
{
    public $fromLogin;

    public function run()
    {
        $action = $this;
        $this->successCallback = function($eauth) use ($action) {
            \Yii::log(print_r($eauth, true), 'info', 'eauth');

            \Yii::app()->user->setState('socialService', array(
                'name' => $eauth->getServiceName(),
                'id' => $eauth->getAttribute('uid'),
            ));

            $socialManager = new SocialManager($eauth);
            $eauth->component->setRedirectView('signup.views.redirect');
            $eauth->redirect(null, $socialManager->getData());
        };

        parent::run();
    }
}