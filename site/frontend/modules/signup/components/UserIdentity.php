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
        /** @var User $model */
        $model = User::model()->active()->findByAttributes(array('email' => $this->username));
        if ($model === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            $this->errorMessage = 'Пользователя с таким e-mail не существует';
        }
        elseif ($model->password != User::hashPassword($this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
            $this->errorMessage = 'Неверный пароль';
        }
        elseif ($model->isBanned) {
            $this->errorCode = self::ERROR_BANNED;
            $this->errorMessage = 'Вы заблокированы';
        }
        else {
            if ($model->status == User::STATUS_INACTIVE) {
                $model->activate();
            }

            foreach ($model->attributes as $k => $v)
                $this->setState($k, $v);
            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode == self::ERROR_NONE;
    }

    public function getId()
    {
        return $this->getState('id');
    }

    public function getName()
    {
        return $this->getState('first_name');
    }
}