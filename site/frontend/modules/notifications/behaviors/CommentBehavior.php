<?php

namespace site\frontend\modules\notifications\behaviors;

/**
 * Поведение рекомендуется привязать к модели Comment
 * У модели, к которой привязывается поведенеие должны быть реализованы:
 * 1. атрибут isNewRecord (по аналогии с CActiveRecord)
 * 2. События (по аналогии с CActiveRecord):
 *  а) onBeforeSave
 *  б) onAfterSave
 *  в) onBeforeDelete
 *  г) onAfterDelete
 *  д) onBeforeFind
 *  е) onAfterFind
 * Поведение отвечает за:
 * 1. Формирование подписки на продолжение дискуссии (класс \site\frontend\modules\notifications\models\DiscussSubscription)
 * 2. Формирование сигналов (класс \site\frontend\modules\notifications\models\Notification)
 *  а) о продолжении дискуссии
 *  б) о новом комментарии/ответе на вопрос
 *  в) об ответе на комментарий
 *
 * @property \Comment $owner 
 * @author Кирилл
 */
class CommentBehavior extends \CActiveRecordBehavior
{

    public function beforeSave($event)
    {
        return parent::beforeSave($event);
    }

    public function afterSave($event)
    {
        if ($this->owner->isNewRecord)
        {
            $this->addNotifications($this->owner);
            // если комментирует не автор, то подпишем его
            if ($this->owner->author_id != $this->owner->commentEntity->author_id)
                $this->addNotificationDiscussSubscription($this->owner);
        }

        return parent::afterSave($event);
    }

    /**
     * 
     * @param \Comment $model
     */
    protected function addNotifications($model)
    {
        $this->addNotificationDiscuss($model);
        $this->addNotificationComment($model);
        $this->addNotificationReply($model);
    }

    /**
     * 
     * @param \Comment $model
     */
    protected function addNotificationDiscuss($model)
    {
        $subscriptions = \site\frontend\modules\notifications\models\DiscussSubscription::model()->byModel(array('entity' => $model->entity, 'entityId' => $model->entity_id))->findAll();
        foreach ($subscriptions as $subscription)
            $this->saveNotificationDiscuss($model, $subscription->userId);
    }

    /**
     * Метод добавляет сигнал "продолжение дискуссии" для пользователя с id $userId.
     * Продолжение дискуссии крепится к контенту, т.е. для одного поста,
     * у одного пользователя может быть только один сигнал "продолжение дискуссии".
     * 
     * @param int $userId Id пользователя, для которого добавляется сигнал
     * @param \Comment $model Модель комментария (сигнал будет привязан к комментируемой сущности)
     */
    protected function saveNotificationDiscuss($model, $userId)
    {
        $notification = $this->findOrCreateNotification($model->entity, $model->entity_id, $userId, \site\frontend\modules\notifications\models\Notification::TYPE_DISCUSS_CONTINUE);

        $comment = new \site\frontend\modules\notifications\models\Entity($model);
        $comment->title = $model->text;

        $notification->unreadEntities[] = $comment;

        $notification->save();
    }

    /**
     * Метод проверяет наличие подписки у пользователя на сигнал "продолжение дискуссии",
     * и если её нет, то добавляет.
     * 
     * @param \Comment $model Модель комментария, подписка создаётся для комментируемой сущности
     */
    protected function addNotificationDiscussSubscription($model)
    {
        $class = '\site\frontend\modules\notifications\models\DiscussSubscription';
        $count = $class::model()->byModel(array('entity' => $model->entity, 'entityId' => $model->entity_id))->byUser($model->author_id)->count();
        // Нет подписки, создаём
        if ($count == 0)
        {
            $subscription = new $class($model->author_id);
            $subscription->entity = $model->entity;
            $subscription->entityId = $model->entity_id;
            $subscription->save();
        }
    }

    /**
     * Метод добавляет сигнал о новом комментарии, этот сигнал:
     * 1. Добавляется для автора комментируемой сущности
     * 2. Создаётся для комментируемой сущности, т.е. для одного поста
     * может быть только один сигнал о новых комментариях, и только у автора поста
     * 
     * @param \Comment $model
     */
    protected function addNotificationComment($model)
    {
        $notification = $this->findOrCreateNotification($model->entity, $model->entity_id, $model->commentEntity->author_id, \site\frontend\modules\notifications\models\Notification::TYPE_USER_CONTENT_COMMENT);

        $comment = new \site\frontend\modules\notifications\models\Entity($model);
        $comment->title = $model->text;

        $notification->unreadEntities[] = $comment;

        $notification->save();
    }

    /**
     * Метод добавляет сигнал об ответе на комментарии, этот сигнал:
     * 1. Добавляется только для автора комментария, на который ответили
     * 2. Создаётся для комментария, на который ответили,
     * т.е. может быть несколько для одного поста
     * 3. Не создаётся для автора комментируемой сущности
     * 
     * @param \Comment $model
     */
    protected function addNotificationReply($model)
    {
        if ($model->author_id == $model->commentEntity->author_id || is_null($model->response))
            return;

        $entity = $model->response;
        $notification = $this->findOrCreateNotification(get_class($entity), $entity->id, $model->author_id, \site\frontend\modules\notifications\models\Notification::TYPE_REPLY_COMMENT);

        $comment = new \site\frontend\modules\notifications\models\Entity($model);
        $comment->title = $model->text;
        $comment->tooltip = $model->commentEntity->powerTipTitle;

        $notification->unreadEntities[] = $comment;

        $notification->save();
    }

    /**
     * Метод находит в базе, или создаёт (не сохраняет в базу) сигнал,
     * связанный с указанными в атрибутах сущностями
     * 
     * @param string $modelClass Класс модели, для которой сигнал
     * @param int $modelId Id модели, для которой сигнал
     * @param int $userId Id пользователя, для которого сигнал
     * @param int $type Тип сигнала (см константы \site\frontend\modules\notifications\models\Notification::TYPE_*)
     * @return \site\frontend\modules\notifications\models\Notification
     */
    protected function findOrCreateNotification($modelClass, $modelId, $userId, $type)
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

        return $notification;
    }

}

?>
