<?php
/**
 * Класс для аутентификации после перехода по ссылке на подтверждение e-mail из письма
 */

class ActivationUserIdentity extends CBaseUserIdentity
{
    const ERROR_CODE_INVALID = 3;

    public $activationCode;

    public function __construct($activationCode)
    {
        $this->activationCode = $activationCode;
    }

    public function authenticate()
    {
        $model = User::model()->findByAttributes(array(
            'activation_code' => $this->activationCode,
            'status' => User::STATUS_INACTIVE,
        ));
        if ($model === null) {
            $this->errorCode = self::ERROR_CODE_INVALID;
            $this->errorMessage = 'Неверный код активации';
        }
        else {
            $model->status = User::STATUS_ACTIVE;
            $model->update(array('status'));
            foreach ($model->attributes as $k => $v)
                $this->setState($k, $v);
            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode == self::ERROR_NONE;
    }
}