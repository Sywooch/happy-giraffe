<?php

namespace site\frontend\modules\notifications\behaviors;

/**
 * Поведение, отмечающее сигналы прочитанными для (get_class($this->owner),$this->owner->id,Yii::app()->user->id)
 *
 * @author Кирилл
 */
class ContentBehavior extends \CActiveRecordBehavior
{

    /** @todo Придумать другой способ */
    public static $active = false;


    public function afterFind($event)
    {
        if (\Yii::app() instanceof \CWebApplication && !\Yii::app()->user->isGuest && self::$active)
            $this->readNotifications(get_class($this->owner), $this->owner->id, \Yii::app()->user->id);
    }

    protected function readNotifications($class, $entityId, $userId)
    {
        $notifications = $this->findNotifications($class, $entityId, $userId);
        foreach ($notifications as $notification)
        {
            $notification->readAll();
            $notification->save();
        }
    }

    /**
     * 
     * @param string $class
     * @param int $entityId
     * @param int $userId
     * @return \site\frontend\modules\notifications\models\Notification
     */
    protected function findNotifications($class, $entityId, $userId)
    {
        $notifications = \site\frontend\modules\notifications\models\Notification::model()
            ->byUser((int) $userId)
            ->byEntity(array('entity' => $class, 'entityId' => (int) $entityId))
            ->byRead(0)
            ->findAll();

        return $notifications;
    }

}

?>
