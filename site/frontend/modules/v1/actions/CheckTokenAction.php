<?php

namespace site\frontend\modules\v1\actions;

use site\frontend\modules\v1\models\UserApiToken;

class CheckTokenAction extends RoutedAction
{
    public function run()
    {
        $this->controller->setAction($this);
        $this->route(null, 'check', null, null);
    }

    public function check()
    {
        $require = array('access_token' => true);

        if ($this->controller->checkParams($require)) {
            $access_token = $this->controller->getParams($require)['access_token'];

            $token = UserApiToken::model()->findByToken($access_token);

            if ($token) {
                if ($token->isAlive()) {
                    $this->controller->data = true;
                } else {
                    $this->controller->setError('DeadToken', 401);
                }
            } else {
                $this->controller->setError('InvalidToken', 401);
            }
        }
    }
}