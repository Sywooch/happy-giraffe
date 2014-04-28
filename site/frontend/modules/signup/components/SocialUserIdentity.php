<?php
/**
 * Класс для аутентификации через социальную сеть
 */

class SocialUserIdentity extends CBaseUserIdentity
{
    const ERROR_BANNED = 3;
    const ERROR_INACTIVE = 4;
    const ERROR_NOT_AUTHENTICATED = 5;
    const ERROR_NOT_ASSOCIATED = 6;

    public $service;
    private $_model;

    public function __construct($service)
    {
        $this->service = $service;
    }

    public function authenticate()
    {
        if (! $this->service->isAuthenticated) {
            $this->errorCode = self::ERROR_NOT_AUTHENTICATED;
            $this->errorMessage = 'Вы не авторизовались в социальной сети';
        }
        else {
            $serviceModel = UserSocialService::model()->findByAttributes(array(
                'service' => $this->service->getServiceName(),
                'service_id' => $this->service->getAttribute('uid'),
            ), array(
                'with' => 'user',
                'condition' => 'user.deleted = 0',
            ));
            if ($serviceModel === null) {
                $this->errorCode = self::ERROR_NOT_ASSOCIATED;
                $this->errorMessage = 'Этот социальный аккаунт не привязан';
            }
            else {
                /** @var User _model */
                $this->_model = User::model()->findByPk($serviceModel->user_id);

                if ($this->_model->status == User::STATUS_INACTIVE) {
                    $this->errorCode = self::ERROR_INACTIVE;
                    $this->errorMessage = 'Вы не подтвердили свой e-mail';
                }
                elseif ($this->_model->isBanned) {
                    $this->errorCode = self::ERROR_BANNED;
                    $this->errorMessage = 'Вы заблокированы';
                }
                else {
                    foreach ($this->_model->attributes as $k => $v)
                        $this->setState($k, $v);
                    $this->errorCode = self::ERROR_NONE;
                }
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
     * @return User
     */
    public function getUserModel()
    {
        return $this->_model;
    }
}