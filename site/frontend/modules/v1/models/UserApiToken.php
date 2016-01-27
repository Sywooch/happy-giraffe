<?php

namespace site\frontend\modules\v1\models;

/**
 * @property $access_token;
 * @property $refresh_token;
 * @property $expire;
 * @property $user_id;
 * @property $date;
 *
 * @property $error;
 * @property $userSocialService;
 */
class UserApiToken extends \EMongoDocument
{
    const EXPIRE_TIME = 5;

    public $access_token;
    public $refresh_token;
    public $user_id;
    public $date;
    public $expire;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'user_api_tokens';
    }

    public function isAlive()
    {
        return time() < $this->expire;
    }

    public function findByToken($token)
    {
        return $this->toObject($this->getCollection()->findOne(array('access_token' => $token)));
    }

    public function findByRefreshToken($token)
    {
        return $this->toObject($this->getcollection()->findOne(array('refresh_token' => $token)));
    }

    //i don't know how to get AR instance by findOne, so create this crutch -_-
    private function toObject($array)
    {
        if (!empty($array)) {
            $result = new self;

            foreach ($array as $key => $value) {
                $result->$key = $value;
            }

            return $result;
        } else {
            return null;
        }
    }

    public function create($user)
    {
        $string = $user->email . $user->password . $user->id . microtime();

        $model = new self;
        $model->access_token = md5($string);

        $model->refresh_token = md5(str_shuffle($string));

        $model->date = time();
        $model->expire = time() + self::EXPIRE_TIME;

        $model->user_id = $user->id;

        $model->_id = $user->id;

        $model->save();

        return $model;
    }
}