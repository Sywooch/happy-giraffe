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
    const STATUS_SPAMER = 4;

    public static function setUserStatus($user, $statusValue)
    {
        if (Yii::app()->user->checkAccess('moderator')) {
            $status = self::getUserStatusModel($user);
            if ($status === null) {
                $status = new AntispamStatus();
                $status->user_id = $user->id;
            }
            $status->status = $statusValue;
            $status->moderator_id = Yii::app()->user->id;
            return $status->save();
        }
        else
            return false;
    }

    public static function getUserStatus($user)
    {
        $status = self::getUserStatusModel($user);
        return $status === null ? self::STATUS_UNDEFINED : $status->status;
    }

    protected static function getUserStatusModel($user)
    {
        return AntispamStatus::model()->findByAttributes(array('user_id' => $user->id));
    }
}