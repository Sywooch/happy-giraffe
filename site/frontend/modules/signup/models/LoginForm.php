<?php
/**
 * Форма для авторизации пользователя по паролю
 */

class LoginForm extends CFormModel
{
    public $email;
    public $password;
    public $rememberMe;

    private $_identity;

    public function rules()
    {
        return array(
            array('email, password', 'required'),
            array('rememberMe', 'boolean'),
            array('password', 'authenticate'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'email' => 'E-mail',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить меня',
        );
    }

    /**
     * Проверка возможности аутентификации
     * @param $attribute
     * @param $params
     */
    public function authenticate($attribute, $params)
    {
        if (! $this->hasErrors())
        {
            $this->_identity = new UserIdentity($this->email, $this->password);
            if (! $this->_identity->authenticate()) {
                $attr = ($this->_identity->errorCode === UserIdentity::ERROR_PASSWORD_INVALID) ? 'password' : 'email';
                $this->addError($attr, $this->_identity->errorMessage);
            }
        }
    }

    /**
     * Аутентификация пользователя
     * @return bool
     */
    public function login()
    {
        if ($this->_identity===null)
        {
            $this->_identity = new UserIdentity($this->email,$this->password);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE)
        {
            $duration = $this->rememberMe ? null : 0;
            Yii::app()->user->login($this->_identity, $duration);
            return true;
        }
        else
            return false;
    }
}
