<?php

namespace site\frontend\components;

/**
 * Description of AuthManager
 *
 * @author Кирилл
 */
class AuthManager extends \CPhpAuthManager
{

    public $authFile = false;
    public $defaultRoles = array('guest');

    public function __construct()
    {
        $this->authFile = \Yii::getPathOfAlias('site.frontend.config') . '/newAuth.php';
    }

    public function init()
    {
        parent::init();
        if (!\Yii::app()->user->isGuest)
            $this->assign('user', \Yii::app()->user->id);
    }

}

?>
