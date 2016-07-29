<?php

namespace site\frontend\modules\quests\components\quests;

use site\frontend\modules\quests\components\BaseQuest;
use site\frontend\modules\quests\components\IQuest;
use site\frontend\modules\quests\components\QuestTypes;

class PostToWallQuest extends BaseQuest implements IQuest
{
    protected function getType()
    {
        if ($this->type == null) {
            $this->type = QuestTypes::POST_TO_WALL;
        }

        return $this->type;
    }

    protected function getQuest()
    {
        return null;
    }

    public function getHandledEvents()
    {
        return array(

        );
    }

    public function run($model, $event)
    {
        $this->model = $model;
        // TODO: Implement run() method.
    }
}