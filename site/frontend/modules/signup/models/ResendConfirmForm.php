<?php
/**
 * Форма обработки повторной отправки письма подтверждения
 */

class ResendConfirmForm extends CFormModel
{
    public $id;
    public $email;
    public $verifyCode;

    public function rules()
    {
        return array(
            array('email, verifyCode', 'required'),
            array('email', 'email'),
            array('id', 'safe'),
        );
    }

    /**
     * Отправка письма
     *
     * Должна генерировать новый пароль, так как он присутствует в тексте письма
     *
     * @return bool
     */
    public function send()
    {
        $user = User::model()->findByPk($this->id);
        if ($user === null)
            return false;

        if ($user->email != $this->email)
            $user->email = $this->email;

        $password = User::createPassword(8);
        $user->password = User::hashPassword($password);

        if ($user->update(array('email', 'password'))) {
            Yii::app()->email->send($this, 'confirmEmail', array(
                'password' => $password,
                'email' => $user->email,
                'first_name' => $user->first_name,
                'activation_url' => Yii::app()->createAbsoluteUrl('/signup/register/confirm', array('activationCode' => $user->activation_code)),
            ));
            return true;
        }
        return false;
    }
}