<?php

namespace site\frontend\modules\signup\components;

/**
*
*/
class PartnerSignupSocialAction extends \CAction
{

    public $fromLogin = false;

    protected function getUserParams()
    {
        $request     = \Yii::app()->request;
        $user = $request->getQuery('user');
        $attributes = $request->getQuery('attributes');
        $service = $request->getQuery('service');
        return [
            'attributes' => $attributes,
            'user' => $user ?: null,
            'service' => $service
            ];
    }

    public function run()
    {

        $sessionUser = \Yii::app()->user;

        if($sessionUser->getState('initAuth')){
            $userParams = $this->getUserParams();
            $this->controller->params = $userParams;

            if( isset($userParams['attributes']['uid']) and !empty($userParams['service'])){
                if(!empty($userParams['user'])){
                    $sessionUser->setState('possibleUserId', $userParams['user']['id']);
                }
                $sessionUser->setState('socialService', array(
                    'name' => $userParams['service'],
                    'id'   => $userParams['attributes']['uid'],
                ));
                $this->controller->renderPartial('signup.views.redirect');

                return;
            }

            throw new \CHttpException(400);
        }

        throw new \CHttpException(403);
    }
}
