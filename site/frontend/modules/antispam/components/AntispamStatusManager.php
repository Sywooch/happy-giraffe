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
    const STATUS_GRAY = 2;
    const STATUS_BLACK = 3;
    const STATUS_BLOCKED = 4;

    public static function setUserStatus($userId, $statusValue)
    {
        $status = self::getUserStatusModel($userId);
        if ($status !== null && $status->status == $statusValue)
            return false;

        if ($statusValue == self::STATUS_WHITE)
            AntispamCheck::changeStatusAll($userId, AntispamCheck::STATUS_UNDEFINED, AntispamCheck::STATUS_GOOD);

        if ($statusValue == self::STATUS_BLACK)
            AntispamCheck::changeStatusAll($userId, AntispamCheck::STATUS_UNDEFINED, AntispamCheck::STATUS_BAD);

        if ($status === null) {
            $status = new AntispamStatus();
            $status->user_id = $userId;
        }
        $status->status = $statusValue;
        $status->moderator_id = Yii::app()->user->id;
        return $status->save() ? $status : false;
    }

    public static function getUserStatus($user)
    {
        $status = self::getUserStatusModel($user);
        return $status === null ? self::STATUS_UNDEFINED : $status->status;
    }

    protected static function getUserStatusModel($userId)
    {
        return AntispamStatus::model()->findByAttributes(array('user_id' => $userId));
    }
}