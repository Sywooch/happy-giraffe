<?php

namespace site\frontend\modules\v1\actions;

use site\frontend\modules\v1\models\UserApiToken;
use site\frontend\modules\v1\components\ApiUserIdentity;

class ReLoginAction extends RoutedAction implements IPostProcessable
{
    public function run()
    {
        $this->controller->setAction($this);
        $this->route(null, 'reLogin', null, null);
    }

    public function reLogin()
    {
        $require = array('refresh_token' => true);

        if ($this->controller->checkParams($require)) {
            $refresh_token = $this->controller->getParams($require)['refresh_token'];

            $this->controller->identity = new ApiUserIdentity(null);
            $this->controller->identity->refresh($refresh_token);

            if ($this->controller->identity->errorMessage == '') {
                $this->controller->data['user'] = \User::model()->findByPk($this->controller->identity->getId());

                $this->controller->data['token'] = $this->controller->identity->token;
            } else {
                $this->controller->setError($this->controller->identity->errorMessage, 401);
            }
        } else {
            $this->controller->setError('ParamsMissing', 401);
        }
    }

    public function postProcessing(&$data)
    {
        $data[0]['token'] = $data[1];
        $data = $data[0];

        $data['avatarInfo'] = $data['avatarInfo'] === '' ? null : $data['avatarInfo'];
    }
}