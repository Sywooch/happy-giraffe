<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 25/02/14
 * Time: 09:25
 * To change this template use File | Settings | File Templates.
 */

class SocialUserIdentity extends CBaseUserIdentity
{
    const ERROR_NOT_AUTHENTICATED = 3;
    const ERROR_NOT_ASSOCIATED = 4;

    public $service;

    public function __construct($service)
    {
        $this->service = $service;
    }

    public function authenticate()
    {
        if (! $this->service->isAuthenticated)
            $this->errorCode = self::ERROR_NOT_AUTHENTICATED;
        else {
            $serviceModel = UserSocialService::model()->findByAttributes(array(
                'service' => $this->service->getServiceName(),
                'service_id' => $this->service->getAttribute('id'),
            ));
            if ($serviceModel === null)
                $this->errorCode = self::ERROR_NOT_ASSOCIATED;
            else {
                $model = User::model()->findByPk($serviceModel->user_id);
                foreach ($model->attributes as $k => $v)
                    $this->setState($k, $v);
                $this->errorCode = self::ERROR_NONE;
            }
        }
        return $this->errorCode == self::ERROR_NONE;
    }
}