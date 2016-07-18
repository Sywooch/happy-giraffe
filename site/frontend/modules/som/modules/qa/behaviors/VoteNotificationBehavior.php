<?php

namespace site\frontend\modules\som\modules\qa\behaviors;
use site\frontend\modules\analytics\models\PageView;
use site\frontend\modules\notifications\behaviors\BaseBehavior;
use site\frontend\modules\notifications\models\Entity;
use site\frontend\modules\notifications\models\Notification;
use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaAnswerVote;

/**
 * @property QaAnswerVote $owner
 */
class VoteNotificationBehavior extends BaseBehavior
{
    const TYPE = 11;

    public function afterSave($event)
    {
        /**
         * @var QaAnswer $answer
         */
        $answer = $this->owner->answer;
        if ($answer->isNewRecord) {
            $this->addNotification($this->owner, $answer);
        }
    }

    public function afterDelete($event)
    {

    }

    protected function removeEntity(&$entities, $model)
    {

    }

    protected function addNotification(QaAnswerVote $vote, QaAnswer $answer)
    {
        $notification = $this->findOrCreateNotification(get_class($answer), $answer->id, $answer->authorId, self::TYPE, array($vote->authorId, $vote->user->avatarUrl));
    }
}