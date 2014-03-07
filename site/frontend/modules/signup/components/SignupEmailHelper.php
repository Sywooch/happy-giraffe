<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 07/03/14
 * Time: 12:15
 * To change this template use File | Settings | File Templates.
 */

class SignupEmailHelper
{
    public static function register(User $user, $password)
    {
        Yii::app()->email->send($user, 'confirmEmail', array(
            'password' => $password,
            'email' => $user->email,
            'first_name' => $user->first_name,
            'activation_url' => Yii::app()->createAbsoluteUrl('/signup/register/confirm', array('activationCode' => $user->activation_code)),
            'change_password_url' => Yii::app()->createAbsoluteUrl('/signup/register/confirm', array('activationCode' => $user->activation_code, 'url' => Yii::app()->createAbsoluteUrl('/profile/settings/password/'))),
        ));
    }

    public static function passwordRecovery(User $user, $password)
    {
        Yii::app()->email->send($user, 'passwordRecovery', array('password' => $password));
    }
}