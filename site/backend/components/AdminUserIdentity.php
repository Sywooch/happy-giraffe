<?php

class AdminUserIdentity extends CUserIdentity
{
    private $_id;
    private $_name;
    private $user = array();

    public function __construct($profile)
    {
        $this->user = $profile;
    }

    public function authenticate()
    {
        $user = User::model()->find(array('condition' => 'email=:email', 'params' => array(':email' => $this->user['email'])));
        if ($user === null) {
            $user = new User;
            $user->attributes = $this->user;
            if (!$user->save()) {
                $this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
            }
            else {
                $this->_id = $user->id;
                $this->saveParams($user);
            }
            return $this->errorCode = self::ERROR_NONE;
        }
        else {
            $this->_id = $user->id;
            $this->saveParams($user);
        }
        return $this->errorCode = self::ERROR_NONE;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getName()
    {
        return $this->_name;
    }

    private function saveParams($user)
    {
        foreach ($user as $k => $v) {
            $this->setState($k, $v);
        }
    }
}