<?php
/**
 * @author Никита
 * @date 11/02/16
 */

namespace site\frontend\modules\signup\components;


use site\frontend\modules\users\models\User;

class SocialManager
{
    protected $service;

    public function __construct(\EAuthServiceBase $service)
    {
        $this->service = $service;
    }

    public function getData()
    {
        $user = $this->findByService();
        if (! $user) {
            $alreadyAssociated = false;
            $user = $this->findByEmail();
        } else {
            $alreadyAssociated = true;
        }

        if ($user) {
            \Yii::app()->user->setState('possibleUserId', $user->id);
        }

        return array(
            'attributes' => $this->service->getAttributes(),
            'user' => ($user) ? $user->toJSON() : null,
            'alreadyAssociated' => $alreadyAssociated,
        );
    }

    protected function findByEmail()
    {
        $user = User::model()->active()->findByAttributes(array(
            'email' => $this->service->getAttribute('email'),
        ));
        return $user;
    }

    protected function findByService()
    {
        /** @var \UserSocialService $service */
        $service = \UserSocialService::model()->activeUser()->findByAttributes(array(
            'service' => $this->service->getServiceName(),
            'service_id' => $this->service->getAttribute('uid'),
        ));
        return ($service) ? $service->user : null;
    }
}
