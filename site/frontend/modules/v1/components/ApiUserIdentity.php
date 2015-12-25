<?php

namespace site\frontend\modules\v1\components;

use site\frontend\modules\v1\models\UserApiToken;

/**
 * Identity for auth from tokens.
 *
 * @property $access_token
 * @property $refresh_token
 * @property $user_id
 * @property $token
 */
class ApiUserIdentity extends \CUserIdentity
{
    public $access_token;
    public $token;

    private $user_id;

    public function __construct($token)
    {
        $this->access_token = $token;
    }

    public function refresh($refresh_token)
    {
        $token = UserApiToken::model()->find(array('refresh_token', $refresh_token));

        if ($token) {
            if ($token->refresh_token == $refresh_token) {
                $this->user_id = $token->user_id;

                $model = \User::model()->active()->findByPk($this->user_id);

                if ($model) {
                    $token->delete();

                    $this->token = UserApiToken::model()->create($model);
                    $this->handleUser();
                } else {
                    $this->errorMessage = 'UserNotFound';
                }
            } else {
                $this->errorMessage = 'RefreshTokenInvalid';
            }
        } else {
            $this->errorMessage = 'TokenNotFound';
        }
    }

    public function authenticate()
    {
        $token = UserApiToken::model()->find(array('access_token', $this->access_token));

        if ($token) {
            if ($token->isAlive()) {
                $this->user_id = $token->user_id;

                $this->handleUser();
            } else {
                $this->errorMessage = 'DeadToken';
            }
        } else {
            $this->errorMessage = 'InvalidToken';
        }

        return $this->errorMessage == '';
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