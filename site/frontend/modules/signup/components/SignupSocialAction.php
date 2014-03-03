<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 03/03/14
 * Time: 16:09
 * To change this template use File | Settings | File Templates.
 */

class SignupSocialAction extends SocialAction
{
    public $fromLogin;

    public function run()
    {
        $this->successCallback = function($eauth) {
            $identity = new SocialUserIdentity($eauth);
            if ($identity->authenticate()) {
                Yii::app()->user->login($identity, 3600*24*30);
                $eauth->redirect();
            } else {
                $eauth->component->setRedirectView('signup.views.redirect');
                $eauth->redirect(null, array(
                    'attributes' => $eauth->getAttributes(),
                    'serviceName' => $eauth->getServiceName(),
                    'fromLogin' => $this->fromLogin,
                ));
            }
        };

        parent::run();
    }
}