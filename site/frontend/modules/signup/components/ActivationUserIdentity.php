<?php
/**
 * Класс для аутентификации после перехода по ссылке на подтверждение e-mail из письма
 */

class ActivationUserIdentity extends CBaseUserIdentity
{
    const ERROR_CODE_INVALID = 3;
    const ERROR_CODE_USED = 4;

    public $activationCode;

    public function __construct($activationCode)
    {
        $this->activationCode = $activationCode;
    }

    public function authenticate()
    {
        $model = User::model()->active()->findByAttributes(array(
            'activation_code' => $this->activationCode,
        ));
        if ($model === null) {
            $this->errorCode = self::ERROR_CODE_INVALID;
            $this->errorMessage = 'Неверный код активации';
        }
        elseif ($model->status == User::STATUS_ACTIVE) {
            $this->errorCode = self::ERROR_CODE_USED;
            $this->errorMessage = 'Код уже активирован';
        }
        else {
            $model->status = User::STATUS_ACTIVE;
            $model->email_confirmed = 1;
            $model->update(array('status', 'email_confirmed'));
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