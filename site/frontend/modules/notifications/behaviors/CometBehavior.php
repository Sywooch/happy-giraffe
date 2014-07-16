<?php

namespace site\frontend\modules\notifications\behaviors;

/**
 * Поведение для модели Notification, реализующую логику работы с Comet-сервером.
 *
 * @property-read \CometModel $comet
 * @property-read \site\frontend\modules\notifications\models\Notification $owner
 * @author Кирилл
 */
class CometBehavior extends \CActiveRecordBehavior
{

    /**
     *
     * @var \CometModel 
     */
    protected static $comet = null;
    protected $_oldUnreadCount = null;

    public static function getComet()
    {

        if (is_null(self::$comet))
        {
            self::$comet = new \CometModel();
        }
        return self::$comet;
    }

    public function afterFind($event)
    {
        $this->_oldUnreadCount = $this->owner->unreadCount;

        return parent::afterFind($event);
    }

    public function afterSave($event)
    {
        $type = $this->owner->isNewRecord ? \CometModel::NOTIFY_ADDED : \CometModel::NOTIFY_UPDATED;
        self::getComet()->send($this->owner->userId, array('notification' => $this->owner->toJSON()), $type);

        $diff = $this->owner->unreadCount - $this->_oldUnreadCount;
        $count = ($this->_oldUnreadCount == 0 ? +1 : ($this->owner->unreadCount == 0 ? -1 : 0));
        if ($diff !== 0)
            $this->comet->send($this->owner->userId, array('unreadSum' => $diff, 'unreadCount' => $count), \CometModel::TYPE_UPDATE_NOTIFICATIONS);

        return parent::afterSave($event);
    }

}

?>
