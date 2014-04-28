<?php
/**
 * Форма генерации нового пароля
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

    /**
     * Генерация и отправка письма
     * @return bool
     */
    public function send()
    {

        /** @var User $user */
        $user = User::model()->active()->findByAttributes(array('email' => $this->email));
        $newPassword = User::createPassword(8);
        $user->password = User::hashPassword($newPassword);
        if ($user->update(array('password'))) {
            if ($user->status == 1)
                SignupEmailHelper::passwordRecovery($user, $newPassword);
            else
                SignupEmailHelper::register($user, $newPassword);
            return true;
        }
        $this->addError('email', 'Неизвестная ошибка, попробуйте еще раз');
        return false;
    }
}