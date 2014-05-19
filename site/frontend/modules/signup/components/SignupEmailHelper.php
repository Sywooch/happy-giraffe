<?php

Yii::import('site.frontend.modules.mail.MailModule');
MailModule::externalImport();

class SignupEmailHelper
{
    public static function register(User $user, $password)
    {
        $message = new MailMessageEmailConfirm($user, compact('password'));
        Yii::app()->postman->send($message);
    }

    public static function passwordRecovery(User $user, $password)
    {
        $message = new MailMessagePasswordRecovery($user, compact('password'));
        Yii::app()->postman->send($message);
    }
}