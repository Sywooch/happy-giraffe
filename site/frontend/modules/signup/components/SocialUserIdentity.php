<?php

namespace site\frontend\modules\signup\components;

/**
 * Класс для аутентификации через социальную сеть
 */

class SocialUserIdentity extends \CBaseUserIdentity
{
    const ERROR_BANNED = 3;
    const ERROR_INACTIVE = 4;
    const ERROR_NOT_AUTHENTICATED = 5;
    const ERROR_NOT_ASSOCIATED = 6;

    protected $serviceName;
    protected $serviceId;
    private $_model;

    public function __construct($serviceName, $serviceId)
    {
        $this->serviceName = $serviceName;
        $this->serviceId = $serviceId;
    }

    public function authenticate()
    {
        $serviceModel = \UserSocialService::model()->findByAttributes(array(
            'service' => $this->serviceName,
            'service_id' => $this->serviceId,
        ), array(
            'with' => 'user',
            'condition' => 'user.deleted = 0',
        ));
        if ($serviceModel === null || $serviceModel->user->status == \User::STATUS_INACTIVE) {
            $this->errorCode = self::ERROR_NOT_ASSOCIATED;
            $this->errorMessage = 'Этот социальный аккаунт не привязан';
        }
        else {
            /** @var \User _model */
            $this->_model = $serviceModel->user;

            if ($this->_model->isBanned) {
                $this->errorCode = self::ERROR_BANNED;
                $this->errorMessage = 'Вы заблокированы';
            }
            else {
                foreach ($this->_model->attributes as $k => $v)
                    $this->setState($k, $v);
                $this->errorCode = self::ERROR_NONE;
            }
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

    /**
     * @return \User
     */
    public function getUserModel()
    {
        return $this->_model;
    }
}