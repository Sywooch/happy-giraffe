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
            $identity = new SocialUserIdentity($eauth);
            if ($identity->authenticate()) {
                \Yii::app()->user->login($identity);
                $eauth->redirect(\Yii::app()->user->returnUrl);
            } else {
                \Yii::app()->user->setState('socialService', array(
                    'name' => $eauth->getServiceName(),
                    'id' => $eauth->getAttribute('uid'),
                ));

                if ($identity->errorCode == SocialUserIdentity::ERROR_NOT_ASSOCIATED) {
                    $eauth->component->setRedirectView('signup.views.redirect');
                    $eauth->redirect(null, array(
                        'attributes' => $eauth->getAttributes(),
                        'serviceName' => $eauth->getServiceName(),
                        'fromLogin' => $action->fromLogin,
                    ));
                } else {
                    header('Content-Type: text/html; charset=utf-8');
                    echo $identity->errorMessage;
                    \Yii::app()->end();
                }
            }
        };

        parent::run();
    }
}