<?php

namespace site\frontend\modules\som\modules\qa\behaviors;

use site\frontend\modules\notifications\behaviors\BaseBehavior;
use site\frontend\modules\som\modules\qa\components\QaManager;

/**
 * Class CometBehavior
 *
 * @package site\frontend\modules\som\modules\qa\behaviors
 * @author Sergey Gubarev
 */
class CometBehavior extends BaseBehavior
{

    /**
     * @inheritdoc
     */
    public function afterSave($event)
    {
        $answer = $this->owner;

        if ($answer->isAnswerToAdditional())
        {
            $questionChannelId = QaManager::getQuestionChannelId($answer->question->id);

            $comet = new \CometModel();
            $comet->send($questionChannelId, $answer->toJSON(), NotificationBehavior::ANSWER_TO_ADDITIONAL);
        }

        return parent::afterSave($event);
    }

}