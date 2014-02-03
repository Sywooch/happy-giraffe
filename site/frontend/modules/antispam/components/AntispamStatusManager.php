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

    public static function setUserStatus($userId, $newStatus)
    {
        $model = self::getUserStatusModel($userId);
        $currentStatus = self::getUserStatusByModel($model);
        
        if ($currentStatus == $newStatus)
            return false;

        if ($newStatus == self::STATUS_WHITE)
            AntispamCheck::changeStatusAll($userId, AntispamCheck::STATUS_UNDEFINED, AntispamCheck::STATUS_GOOD);

        if ($newStatus == self::STATUS_BLACK)
            AntispamCheck::changeStatusAll($userId, AntispamCheck::STATUS_UNDEFINED, AntispamCheck::STATUS_MASS_REMOVED);

        if ($currentStatus == self::STATUS_BLACK)
            AntispamCheck::changeStatusAll($userId, AntispamCheck::STATUS_MASS_REMOVED, AntispamCheck::STATUS_UNDEFINED);

        if ($model === null) {
            $model = new AntispamStatus();
            $model->user_id = $userId;
        }
        $model->status = $newStatus;
        $model->moderator_id = Yii::app()->user->id;
        return $model->save() ? $model : false;
    }

    public static function getUserStatus($userId)
    {
        $status = self::getUserStatusModel($userId);
        return self::getUserStatusByModel($status);
    }

    public static function getUserStatusModel($userId)
    {
        return AntispamStatus::model()->findByAttributes(array('user_id' => $userId));
    }
    
    protected static function getUserStatusByModel($model)
    {
        return $model === null ? self::STATUS_UNDEFINED : $model->status;
    }
}