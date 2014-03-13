<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 06/03/14
 * Time: 12:20
 * To change this template use File | Settings | File Templates.
 */

class RegisterCaptchaAction extends CaptchaExtendedAction
{
    protected function getSessionKey()
    {
        return parent::getSessionKey() . $this->getId();
    }
}