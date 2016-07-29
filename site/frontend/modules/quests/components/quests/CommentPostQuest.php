<?php

namespace site\frontend\modules\quests\components\quests;

use site\frontend\modules\quests\components\BaseQuest;
use site\frontend\modules\quests\components\IQuest;
use site\frontend\modules\quests\components\QuestEvents;
use site\frontend\modules\quests\components\QuestTypes;
use site\frontend\modules\quests\models\Quest;

class CommentPostQuest extends BaseQuest implements IQuest
{
    protected function getType()
    {
        if ($this->type == null) {
            $this->type = QuestTypes::COMMENT_POST;
        }

        return $this->type;
    }

    protected function getQuest()
    {
        if (!$this->instance) {
            $this->instance = Quest::model()
                ->byUser($this->getUserId())
                ->byType($this->getType())
                ->byModel((new \ReflectionClass($this->model->post))->getShortName(), $this->model->post->id)
                ->find();
        }

        return $this->instance;
    }

    public function getHandledEvents()
    {
        return array(
            QuestEvents::CREATE
        );
    }

    public function run($model, $event)
    {
        $this->model = $model;
        // TODO: Implement run() method.
    }
}