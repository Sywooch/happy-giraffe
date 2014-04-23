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
                Yii::app()->user->login($identity);
                $eauth->redirect(Yii::app()->user->returnUrl);
            } else {
                if ($identity->errorCode == SocialUserIdentity::ERROR_NOT_ASSOCIATED) {
                    $eauth->component->setRedirectView('signup.views.redirect');
                    $eauth->redirect(null, array(
                        'attributes' => $eauth->getAttributes(),
                        'serviceName' => $eauth->getServiceName(),
                        'fromLogin' => $action->fromLogin,
                    ));
                } elseif ($identity->errorCode == SocialUserIdentity::ERROR_INACTIVE) {
                    $eauth->component->setRedirectView('signup.views.activateRedirect');
                    $eauth->redirect(null, array(
                        'attributes' => $identity->getUserModel()->getAttributes(),
                    ));
                } else {
                    header('Content-Type: text/html; charset=utf-8');
                    echo $identity->errorMessage;
                    Yii::app()->end();
                }
            }
        };

        parent::run();
    }
}