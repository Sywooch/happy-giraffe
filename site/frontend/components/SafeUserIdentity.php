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
        if ($user !== null){
            $this->setNotGuestCookie();
            return true;
        }

        return false;
    }

    public function getId()
    {
        return $this->user_id;
    }

    public function setNotGuestCookie()
    {
        //set cookie for user that autentificated somewhere
        $cookie = new CHttpCookie('not_guest', '1');
        $cookie->expire = time() + 3600*24*100;
        Yii::app()->request->cookies['not_guest'] = $cookie;
    }
}
