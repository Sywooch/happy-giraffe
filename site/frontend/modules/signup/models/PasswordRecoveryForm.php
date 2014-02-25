<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 25/02/14
 * Time: 11:18
 * To change this template use File | Settings | File Templates.
 */

class PasswordRecoveryForm extends CFormModel
{
    public $email;

    public function rules()
    {
        return array(
            array('email', 'required'),
            array('email', 'email'),
            array('email', 'exist', 'className' => 'User', 'attributeName' => 'email', 'message' => 'Пользователя с таким e-mail не существует'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'email' => 'E-mail',
        );
    }

    public function send()
    {
        $user = User::model()->findByAttributes(array('email' => $this->email));
        $newPassword = User::createPassword(8);
        $user->password = User::hashPassword($newPassword);
        if ($user->update(array('password')) && Yii::app()->email->send($user, 'passwordRecovery', array('password' => $newPassword)))
            return true;
        $this->addError('email', 'Неизвестная ошибка, попробуйте еще раз');
        return false;
    }
}