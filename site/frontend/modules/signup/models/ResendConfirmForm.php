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
            array('verifyCode', 'CaptchaExtendedValidator', 'allowEmpty'=> ! CCaptcha::checkRequirements() || YII_DEBUG, 'captchaAction' => '/signup/register/captcha2'),
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
            SignupEmailHelper::register($user, $password);
            return true;
        }
        $this->addError('email', 'Неизвестная ошибка, попробуйте еще раз');
        return false;
    }
}