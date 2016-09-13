<?php

namespace site\frontend\modules\som\modules\qa\behaviors;
use site\frontend\modules\notifications\behaviors\BaseBehavior;
use site\frontend\modules\notifications\models\Entity;
use site\frontend\modules\notifications\models\Notification;
use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaAnswerVote;
use site\frontend\modules\som\modules\qa\models\QaCategory;

/**
 * @property QaAnswerVote $owner
 */
class VoteNotificationBehavior extends BaseBehavior
{
    const PEDIATRICIAN_TYPE = 16;
    const TYPE = 11;

    public function afterSave($event)
    {
        /**
         * @var QaAnswer $answer
         */
        $this->addNotification($this->owner, $this->owner->answer);
        return parent::afterSave($event);
    }

    public function beforeDelete($event)
    {
        /**
         * @var Notification[] $signals
         */
        $signals = Notification::model()->byEntity($this->owner->answer)->findAll();

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

        return parent::beforeDelete($event);
    }

    protected function removeEntity(&$entities, $model)
    {
        foreach ($entities as $k => $entity) {
            if ($entity->userId == $this->owner->userId && $entity->class == get_class($model)) {
                unset($entities[$k]);
                return true;
            }
        }
        return false;
    }

    protected function addNotification(QaAnswerVote $vote, QaAnswer $answer)
    {
        $type = $answer->question->categoryId == QaCategory::PEDIATRICIAN_ID ? self::PEDIATRICIAN_TYPE : self::TYPE;
        $notification = $this->findOrCreateNotification(get_class($answer), $answer->id, $answer->authorId, $type, array($vote->userId, $vote->user->avatarUrl));
        $entity = new Entity($vote);
        $entity->userId = $vote->userId;

        $entity->title = $answer->text;

        $notification->unreadEntities[] = $entity;
        $notification->save();
    }
}