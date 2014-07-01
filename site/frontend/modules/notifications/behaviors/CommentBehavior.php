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
class CommentBehavior extends BaseBehavior
{

    public function afterSave($event)
    {
        if ($this->owner->isNewRecord)
        {
            $this->addNotifications($this->owner);
            // если комментирует не автор, то подпишем его
            if ($this->owner->author_id != $this->owner->commentEntity->author_id)
                $this->addNotificationDiscussSubscription($this->owner);
        } elseif ($this->owner->removed)
        {
            $this->afterRemove($this->owner);
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
     * Комментарий помечен как удалённый
     * 1. Найти все сигналы для этого коммента
     * 2. Поменять тексты на Comment::getRemoveDescription
     * 3. Удаляем ссылку
     * 4. Проверяем есть ли ещё комментарии у данного пользователя и удаляем подписку, если нет
     * 
     * @param \Comment $model
     */
    protected function afterRemove($model)
    {
        // Находим все сигналы, у которых в прочитанных или непрочитанных сигналах есть
        // интересующая нас сущность
        $signals = \site\frontend\modules\notifications\models\Notification::model()->byInitiatingEntity($model)->findAll();
        // Перебирём все сигналы, а в них все сущности, проставив новый текст, и сохранив их
        foreach ($signals as &$signal)
        {
            $save = false;
            if ($signal->readEntities)
                foreach ($signal->readEntities as &$entity)
                {
                    if ($entity->id == $model->id && $entity->class == get_class($model))
                    {
                        $entity->title = $model->getRemoveDescription();
                        $entity->url = $model->commentEntity->url;
                        $save = true;
                        break;
                    }
                }
            if ($signal->unreadEntities || !$save)
                foreach ($signal->unreadEntities as &$entity)
                {
                    if ($entity->id == $model->id && $entity->class == get_class($model))
                    {
                        $entity->title = $model->getRemoveDescription();
                        $entity->url = $model->commentEntity->url;
                        $save = true;
                        break;
                    }
                }
            if ($save)
                $signal->save();
        }

        // Удаление подписки
        $count = \Comment::model()->countByAttributes(array(
            'author_id' => $model->author_id,
            'entity' => $model->entity,
            'entity_id' => $model->entity_id,
        ));
        if ($count == 0)
            \site\frontend\modules\notifications\models\DiscussSubscription::model()->byUser((int) $model->author_id)->byModel($model->commentEntity)->deleteAll();
    }

    /**
     * 
     * @param \Comment $model
     */
    protected function addNotificationDiscuss($model)
    {
        $subscriptions = \site\frontend\modules\notifications\models\DiscussSubscription::model()->byModel(array('entity' => $model->entity, 'entityId' => (int) $model->entity_id))->findAll();
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
        $notification = $this->findOrCreateNotification($model->entity, $model->entity_id, $userId, \site\frontend\modules\notifications\models\Notification::TYPE_DISCUSS_CONTINUE, array($model->author_id, $model->author->getAvaOrDefaultImage(\Avatar::SIZE_MICRO)));

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
        $count = $class::model()->byModel(array('entity' => $model->entity, 'entityId' => (int) $model->entity_id))->byUser($model->author_id)->count();
        // Нет подписки, создаём
        if ($count == 0)
        {
            $subscription = new $class((int) $model->author_id);
            $subscription->entity = $model->entity;
            $subscription->entityId = (int) $model->entity_id;
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
        $notification = $this->findOrCreateNotification($model->entity, $model->entity_id, $model->commentEntity->author_id, \site\frontend\modules\notifications\models\Notification::TYPE_USER_CONTENT_COMMENT, array($model->author_id, $model->author->getAvaOrDefaultImage(\Avatar::SIZE_MICRO)));

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
        $notification = $this->findOrCreateNotification(get_class($entity), $entity->id, $model->response->author_id, \site\frontend\modules\notifications\models\Notification::TYPE_REPLY_COMMENT, array($model->author_id, $model->author->getAvaOrDefaultImage(\Avatar::SIZE_MICRO)));
        $notification->entity->title = $model->response->text;

        $comment = new \site\frontend\modules\notifications\models\Entity($model);
        $comment->title = $model->text;
        $comment->tooltip = $model->commentEntity->powerTipTitle;

        $notification->unreadEntities[] = $comment;

        $notification->save();
    }

}

?>
