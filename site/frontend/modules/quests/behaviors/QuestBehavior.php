<?php
namespace site\frontend\modules\quests\behaviors;

use site\frontend\modules\quests\components\QuestEvents;
use site\frontend\modules\quests\components\QuestsManager;
use site\frontend\modules\quests\components\QuestTypes;

/**
 * @property int $type;
 */
class QuestBehavior extends \CActiveRecordBehavior
{
    public $type;

    public function afterSave($event)
    {
        QuestsManager::handleQuest(
            $this->type,
            $this->owner->isNewRecord ? QuestEvents::CREATE : QuestEvents::UPDATE,
            $this->owner
            );
        return parent::afterSave($event);
    }

    public function afterDelete($event)
    {
        QuestsManager::handleQuest(
            $this->type,
            QuestEvents::DELETE,
            $this->owner
        );
        return parent::afterDelete($event);
    }
}