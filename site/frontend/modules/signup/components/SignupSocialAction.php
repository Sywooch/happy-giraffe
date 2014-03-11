<?php
/**
 * Действие контроллера, обрабатывающая аутентификацию через социальные сети
 */

class SignupSocialAction extends SocialAction
{
    public $fromLogin;

    public function run()
    {
        $action = $this;
        $this->successCallback = function($eauth) use ($action) {
            $identity = new SocialUserIdentity($eauth);
            if ($identity->authenticate()) {
                Yii::app()->user->login($identity, 3600*24*30);
                $eauth->redirect(Yii::app()->user->returnUrl);
            } else {
                if ($identity->errorCode == SocialUserIdentity::ERROR_NOT_ASSOCIATED) {
                    $eauth->component->setRedirectView('signup.views.redirect');
                    $eauth->redirect(null, array(
                        'attributes' => $eauth->getAttributes(),
                        'serviceName' => $eauth->getServiceName(),
                        'fromLogin' => $action->fromLogin,
                    ));
                } else
                    echo $identity->errorMessage;
            }
        };

        parent::run();
    }
}