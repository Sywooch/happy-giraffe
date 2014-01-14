<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 14/01/14
 * Time: 16:59
 * To change this template use File | Settings | File Templates.
 */

class AntispamStatusManager
{
    const STATUS_UNDEFINED = 0;
    const STATUS_WHITE = 1;
    const STATUS_BLACK = 2;
    const STATUS_SPAMER = 3;

    static function setUserStatus($user, $status)
    {
        return true;
    }

    static function getUserStatus($user)
    {
        return self::STATUS_UNDEFINED;
    }
}