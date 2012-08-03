<?php
/**
 * Author: choo
 * Date: 03.08.2012
 */
class SafeUserIdentity extends CUserIdentity
{
    public $user_id;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    public function authenticate()
    {
        $user = User::model()->findByPk($this->user_id);
        if ($user !== null)
            $this->errorCode = self::ERROR_NONE;
        return ! $this->errorCode;
    }
}
