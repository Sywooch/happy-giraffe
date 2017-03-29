<?php

namespace site\frontend\modules\iframe\modules\notifications\behaviors;

use site\frontend\modules\notifications\models\Notification;
use site\frontend\modules\som\modules\qa\models\QaQuestion;
use site\frontend\modules\som\modules\qa\components\QaObjectList;
use site\frontend\modules\som\modules\qa\models\QaAnswerVote;
use site\frontend\modules\som\modules\qa\models\QaAnswer;

/**
 * Поведение, отмечающее сигналы прочитанными для (get_class($this->owner),$this->owner->id,Yii::app()->user->id)
 *
 * @author Кирилл
 */
class ContentBehavior extends \CActiveRecordBehavior
{
    public $pkAttribute = 'id';
    public $entityClass = null;

    /** @todo Придумать другой способ */
    public static $active = false;

    public function afterFind($event)
    {
        if (\Yii::app() instanceof \CWebApplication && !\Yii::app()->user->isGuest && self::$active)
            $this->readNotifications($this->getEntityClass(), $this->getEntityId(), \Yii::app()->user->id);
    }

    public function getEntityClass()
    {
        if (is_string($this->entityClass)) {
            return $this->entityClass;
        } elseif (is_array($this->entityClass)) {
            return call_user_func($this->entityClass, $this->owner);
        } else {
            return get_class($this->owner);
        }
    }

    public function getEntityId()
    {
        $name = $this->pkAttribute;
        return $this->owner->$name;
    }

    protected function readNotifications($class, $entityId, $userId)
    {
        $notifications = $this->findNotifications($class, $entityId, $userId);

        foreach ($notifications as $notification) {
            $notification->readAll();
            $notification->save();
        }
    }

    /**
     * @param string $class
     * @param int $entityId
     * @param int $userId
     * @return \site\frontend\modules\notifications\models\Notification[]
     */
    protected function findNotifications($class, $entityId, $userId)
    {
        $notifications = Notification::model()
            ->byUser((int) $userId)
            ->byEntity(['entity' => $class, 'entityId' => (int)$entityId])
            ->byRead(0)
            ->findAll()
        ;

        if ($class != QaQuestion::class)
        {
            return $notifications;
        }

        $answersIds = array_map(function($item){
            if ($item->votesCount > 0)
            {
                return (int)$item->id;
            }
        }, $this->getOwner()->answers);

        if (empty($answersIds))
        {
            return $notifications;
        }

        $notification = Notification::model()
            ->byUser((int) $userId)
            ->byRead(0);

        $notification->dbCriteria->addCond('entity.class', '==', QaAnswer::class);
        $notification->dbCriteria->addCond('entity.id', 'in', $answersIds);
        $answerNotifications = $notification->findAll();

        if (empty($answerNotifications))
        {
            return $notifications;
        }

        return array_merge($answerNotifications, $notifications);

    }

}

?>
