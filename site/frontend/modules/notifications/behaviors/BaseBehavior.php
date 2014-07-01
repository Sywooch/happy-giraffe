<?php

namespace site\frontend\modules\notifications\behaviors;

/**
 * Description of BaseBehavior
 *
 * @author Кирилл
 * @property \CactiveRecord $owner Owner
 */
class BaseBehavior extends \CBehavior
{

    public function events()
    {
        return array_merge(parent::events(), array(
            'onBeforeSave' => 'beforeSave',
            'onAfterSave' => 'afterSave',
            'onBeforeDelete' => 'beforeDelete',
            'onAfterDelete' => 'afterDelete',
            'onBeforeFind' => 'beforeFind',
            'onAfterFind' => 'afterFind',
        ));
    }

    public function beforeSave($event)
    {
        return true;
    }

    public function afterSave($event)
    {
        return true;
    }

    public function beforeDelete($event)
    {
        return true;
    }

    public function afterDelete($event)
    {
        return true;
    }

    public function beforeFind($event)
    {
        return true;
    }

    public function afterFind($event)
    {
        return true;
    }

    /**
     * Метод находит в базе, или создаёт (не сохраняет в базу) сигнал,
     * связанный с указанными в атрибутах сущностями
     * 
     * @param string $modelClass Класс модели, для которой сигнал
     * @param int $modelId Id модели, для которой сигнал
     * @param int $userId Id пользователя, для которого сигнал
     * @param int $type Тип сигнала (см константы \site\frontend\modules\notifications\models\Notification::TYPE_*)
     * @param array $avatar Массив (id пользователя, url аватарки)
     * @return \site\frontend\modules\notifications\models\Notification
     */
    protected function findOrCreateNotification($modelClass, $modelId, $userId, $type, $avatar = false)
    {
        $notification = \site\frontend\modules\notifications\models\Notification::model()
            ->byType($type)
            ->byUser((int) $userId)
            ->byEntity(array('entity' => $modelClass, 'entityId' => (int) $modelId))
            ->find();
        if (is_null($notification))
        {
            $entity = \CActiveRecord::model($modelClass)->findByPk($modelId);
            $notification = new \site\frontend\modules\notifications\models\Notification();
            $notification->userId = (int) $userId;
            $notification->type = $type;
            $notification->entity = new \site\frontend\modules\notifications\models\Entity($entity);
        }

        // Добавим аватарку
        if ($avatar)
            $notification->addAvatar($avatar[0], $avatar[1]);

        return $notification;
    }

}

?>
