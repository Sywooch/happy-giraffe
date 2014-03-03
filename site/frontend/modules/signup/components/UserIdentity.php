<?php
/**
 * Класс для аутентификации по e-mail и паролю
 */

class UserIdentity extends CUserIdentity
{
    const ERROR_BANNED = 3;
    const ERROR_INACTIVE = 4;

    public function authenticate()
    {
        $model = User::model()->findByAttributes(array('email' => $this->username));
        if ($model === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            $this->errorMessage = 'Пользователя с таким e-mail не существует';
        }
        elseif ($model->password != User::hashPassword($this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
            $this->errorMessage = 'Неверный пароль';
        }
        elseif ($model->status == User::STATUS_INACTIVE) {
            $this->errorCode = self::ERROR_INACTIVE;
            $this->errorMessage = 'Вы не подтвердили свой e-mail';
        }
        elseif ($model->isBanned) {
            $this->errorCode = self::ERROR_BANNED;
            $this->errorMessage = 'Вы заблокированы';
        }
        else {
            foreach ($model->attributes as $k => $v)
                $this->setState($k, $v);
            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode == self::ERROR_NONE;
    }
}