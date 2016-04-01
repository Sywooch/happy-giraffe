<?php
/**
 * @author Никита
 * @date 29/03/16
 */

namespace site\frontend\modules\som\modules\qa\behaviors;
use site\frontend\modules\analytics\models\PageView;
use site\frontend\modules\notifications\behaviors\BaseBehavior;
use site\frontend\modules\notifications\models\Entity;
use site\frontend\modules\notifications\models\Notification;
use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaQuestion;

class NotificationBehavior extends BaseBehavior
{
    const TYPE = 10;

    public function afterSave($event)
    {

        /** @var \site\frontend\modules\som\modules\qa\models\QaQuestion $question */
        $question = $this->owner->question;
        if ($this->owner->isNewRecord && $question->sendNotifications) {
            $this->addNotification($this->owner, $question);
        }

        if ($this->owner->isRemoved == 1) {
            $signals = Notification::model()->byEntity($question)->findAll();

            foreach ($signals as &$signal) {
                if ($this->removeEntity($signal->readEntities, $this->owner) || $this->removeEntity($signal->unreadEntities, $this->owner)) {
                    if ((count($signal->readEntities) + count($signal->unreadEntities)) == 0) {
                        $signal->delete();
                    } else {
                        $signal->save();
                    }
                }
            }
        }

        return parent::afterSave($event);
    }

    protected function removeEntity(&$entities, $model)
    {
        foreach ($entities as $k => $entity) {
            if ($entity->id == $this->owner->id && $entity->class == get_class($model)) {
                unset($entities[$k]);
                return true;
            }
        }
        return false;
    }

    protected function addNotification(QaAnswer $model, QaQuestion $question)
    {
        $notification = $this->findOrCreateNotification(get_class($question), $question->id, $question->authorId, self::TYPE, array($model->authorId, $model->user->avatarUrl));
        $notification->entity->tooltip = $question->title;

        $entity = new Entity($model);
        $entity->userId = $model->authorId;
        $entity->title = $model->text;
        $entity->url = $question->url;
        $notification->unreadEntities[] = $entity;
        $notification->save();
    }
}