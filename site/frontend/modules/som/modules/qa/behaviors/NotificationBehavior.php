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
        \CommentLogger::model()->addToLog('NotificationBehavior', 'start -> afterSave()');
        /** @var \site\frontend\modules\som\modules\qa\models\QaQuestion $question */
        $question = $this->owner->question;
        if ($this->owner->isNewRecord && $question->sendNotifications) {
            \CommentLogger::model()->addToLog('NotificationBehavior:afterSave', 'before add new notification');
            $this->addNotification($this->owner, $question);
            \CommentLogger::model()->addToLog('NotificationBehavior:afterSave', 'after add new notification');
        }

        if ($this->owner->isRemoved == 1) {
            /**
             * @var Notification[] $signals
             */
            \CommentLogger::model()->addToLog('NotificationBehavior:afterSave', 'row is removed, before find signals? O_o');
            $signals = Notification::model()->byEntity($question)->findAll();
            \CommentLogger::model()->addToLog('NotificationBehavior:afterSave', 'row is removed, after find signals, before forech. objCount: ' . count($signals));

            foreach ($signals as &$signal) {
                $readEntityDeleted = $signal->readEntities && $this->removeEntity($signal->readEntities, $this->owner);
                $unreadEntityDeleted = $signal->unreadEntities && $this->removeEntity($signal->unreadEntities, $this->owner);
                if ($readEntityDeleted || $unreadEntityDeleted) {
                    if ((count($signal->readEntities) + count($signal->unreadEntities)) == 0) {
                        $signal->delete();
                    } else {
                        $signal->save();
                    }
                }
            }
            \CommentLogger::model()->addToLog('NotificationBehavior:afterSave', 'after forech');
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
        \CommentLogger::model()->addToLog('NotificationBehavior:addNotification', 'before find data');
        $notification = $this->findOrCreateNotification(get_class($question), $question->id, $question->authorId, self::TYPE, array($model->authorId, $model->user->avatarUrl));
        \CommentLogger::model()->addToLog('NotificationBehavior:addNotification', 'after find data');

        $notification->entity->tooltip = $question->title;

        \CommentLogger::model()->addToLog('NotificationBehavior:addNotification', 'before create object and fill data');
        $entity = new Entity($model);
        $entity->userId = $model->authorId;
        $entity->title = $model->text;
        $entity->url = $question->url;
        $notification->unreadEntities[] = $entity;
        \CommentLogger::model()->addToLog('NotificationBehavior:addNotification', 'after create object and fill data, before save object');
        $notification->save();
        \CommentLogger::model()->addToLog('NotificationBehavior:addNotification', 'after save object');
    }
}