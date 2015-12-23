<?php

namespace site\frontend\modules\v1\components;

use site\frontend\modules\v1\models\UserSocialToken;

/**
 * @property $token;
 * @property $service;
 * @property $user_id;
 */
class ApiSocialUserIdentity extends \CUserIdentity
{
    public $token;
    public $service;

    private $user_id;

    public function __construct($token, $service = null)
    {
        $this->token = $token;
        $this->service = $service;
    }

    public function authenticate()
    {
        $tokenModel = UserSocialToken::model()->findByAttributes(array('access_token' => $this->token));

        if ($tokenModel) {
            if ($tokenModel->isAlive()) {
                if ($this->token == $tokenModel->access_token) {
                    $this->user_id = $tokenModel->user_id;
                    $this->handleUser();

                    return true;
                } else {
                    $this->errorMessage = 'InvalidToken';
                }
            } else {
                $this->errorMessage = 'TokenExpires';
            }
        } else {
            if ($this->service) {
                $tokenModel = UserSocialToken::model()->create($this->token, $this->service);
                if ($tokenModel->error == '') {
                    $this->user_id = $tokenModel->user_id;

                    $tokens = UserSocialToken::model()->findAll(array('user_id' => $this->user_id));

                    if (count($tokens) > 1) {
                        foreach ($tokens as $token) {
                            if ($token->access_token != $this->token) {
                                $token->delete();
                            }
                        }
                    }

                    $this->handleUser();
                    return true;
                } else {
                    $this->errorMessage = $tokenModel->error;
                }
            } else {
                $this->errorMessage = 'ServiceRequired';
            }
        }

        return false;
    }

    private function handleUser()
    {
        if ($this->user_id) {
            $model = \User::model()->active()->findByPk($this->user_id);
            if ($model === null || $model->status == \User::STATUS_INACTIVE) {
                $this->errorMessage = 'Unregistered';
            } elseif ($model->isBanned) {
                $this->errorMessage = 'Banned';
            }
            else {
                foreach ($model->attributes as $k => $v) {
                    $this->setState($k, $v);
                }
            }
        }
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