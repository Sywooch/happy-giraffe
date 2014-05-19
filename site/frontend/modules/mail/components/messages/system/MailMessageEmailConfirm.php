<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 24/04/14
 * Time: 14:44
 * To change this template use File | Settings | File Templates.
 */

class MailMessageEmailConfirm extends MailMessage
{
    public $type = 'confirmEmail';

    public $password;

    public function getSubject()
    {
        return 'Подтверждение e-mail - Весёлый Жираф';
    }

    public function getActivationUrl()
    {
        return Yii::app()->createAbsoluteUrl('/signup/register/confirm', array('activationCode' => $this->user->activation_code));
    }

    public function getChangePasswordUrl()
    {
        return Yii::app()->createAbsoluteUrl('/signup/register/confirm', array('activationCode' => $this->user->activation_code, 'url' => Yii::app()->createAbsoluteUrl('/profile/settings/password')));
    }
}