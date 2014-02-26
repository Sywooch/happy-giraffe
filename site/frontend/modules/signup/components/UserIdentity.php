<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 24/02/14
 * Time: 17:55
 * To change this template use File | Settings | File Templates.
 */

class UserIdentity extends CUserIdentity
{
    const ERROR_BANNED = 3;

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
        elseif ($this->isBanned($model)) {
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

    protected function isBanned($model)
    {
        return in_array(AntispamStatusManager::getUserStatus($model->id), array(AntispamStatusManager::STATUS_BLOCKED, AntispamStatusManager::STATUS_BLACK));
    }
}