<?php

namespace site\frontend\modules\v1\actions;

use site\frontend\modules\v1\models\UserApiToken;
use site\frontend\modules\v1\components\ApiUserIdentity;

class LogoutAction extends RoutedAction
{
    public function run()
    {
        $this->controller->setAction($this);
        $this->route(null, 'logout', null, null);
    }

    public function logout()
    {
        $require = array('access_token' => true);

        if ($this->controller->checkParams($require)) {
            $access_token = $this->controller->getParams($require)['access_token'];

            $token = UserApiToken::model()->find(array('access_token' => $access_token));

            $token->expire = time();
            $token->save();
            $this->controller->data = $token;
        } else {
            $this->controller->setError('ParamsMissing', 400);
        }
    }
}