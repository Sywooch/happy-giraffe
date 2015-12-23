<?php

namespace site\frontend\modules\v1\models;

/**
 * @property $access_token;
 * @property $expire;
 * @property $user_id;
 * @property $date;
 * @property $service_user_id;
 * @property $service;
 *
 * @property $error;
 * @property $userSocialService;
 */
class UserSocialToken extends \EMongoDocument
{
    public $access_token;
    public $expire;
    public $date;
    public $user_id;
    public $service_user_id;
    public $service;

    public $error = '';

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'user_social_tokens';
    }

    public function refresh($access_token)
    {
        if ($this->makeValidationRequest($access_token, $this->service, $this)) {
            $this->access_token = $access_token;
            $this->save();
            return true;
        } else {
            $this->error = 'TokenInvalid';
            return false;
        }
    }

    public function create($token, $service)
    {
        $model = new self;

        $model->service = $service;

        if ($this->makeValidationRequest($token, $model)) {
            $model->access_token = $token;

            $userSocialService = \UserSocialService::model()->findByAttributes(array(
                'service_id' => $model->service_user_id,
                'service' => $model->service
                ));

            if ($userSocialService != null) {
                $model->user_id = $userSocialService->user_id;
                $model->save();

                return $model;
            } else {
                $model->error = 'Unregistered';
            }
        }

        return $model;
    }

    public function isAlive()
    {
        return time() < $this->expire;
    }

    private function makeValidationRequest($token, $model = null)
    {
        return $this->switchservice($model->service, $token, $model == null ? $this : $model);
    }

    private function switchService($service, $token, $model) {
        if ($service) {
            switch ($service) {
                case 'vkontakte':
                    return $this->makeVkRequest($token, $model);
                    break;
                case 'odnoklassniki':
                    return $this->makeOkRequest($token, $model);
                    break;
                default:
                    $model->error = 'NotSupportedService';
                    return false;
            }
        } else {
            $model->error = 'ServiceMissing';
            return false;
        }
    }

    private function makeVkRequest($token, $model)
    {
        $params = \Yii::app()->eauth->services['vk_api'];

        $url = 'https://oauth.vk.com/access_token?client_id='
            . $params['client_id'] .
            '&client_secret='
            . $params['client_secret'] .
            '&v=5.41&grant_type=client_credentials';

        $result = $this->makeRequest($url);

        if (!isset($result->access_token)) {
            $model->error = 'EmptyToken';
            return false;
        }

        $url = 'https://api.vk.com/method/secure.checkToken?access_token='
            . $result->access_token .
            '&token='
            . $token .
            '&client_secret='
            . $params['client_secret'] .
            '&v=5.41';

        $result = $this->makeRequest($url);

        //\Yii::log(var_dump($result), 'info', 'api');

        if (isset($result->response->success)) {
            $model->date = $result->response->date;
            $model->expire = $result->response->expire;
            $model->service_user_id = $result->response->user_id;

            return true;
        } else {
            $model->error = $result->error->error_msg;
            return false;
        }
    }

    private function makeOkRequest($token, $model)
    {
        $params = \Yii::app()->eauth->services['odnoklassniki'];

        $method = 'method=users.getInfo';

        $temp = 'application_key=' . $params['client_public'] . $method;

        $sig = strtolower(md5($temp . md5($token . $params['client_secret'])));

        $url = 'https://api.ok.ru/fb.do?'
            . 'application_key=' . $params['client_public']
            . '&' . $method
            . '&access_token=' . $token
            . '&format=json'
            . '&sig=' . $sig;

        $result = $this->makeRequest($url);

        //\Yii::log('asd' . print_r($result), 'info', 'api');

        if ($result == true) {
            $model->expires = time() + (24 * 60 * 60);
            $model->date = time();

            $model->error = 'Something';
            return false;
        } else {
            $model->error = 'TokenInvalid';
            return false;
        }
    }

    private function makeRequest($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);

        $result = json_decode(curl_exec($ch));

        curl_close($ch);

        return $result;
    }
}