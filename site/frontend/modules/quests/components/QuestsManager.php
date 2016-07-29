<?php

namespace site\frontend\modules\quests\components;

use site\frontend\modules\quests\models\Quest;

/**
 * @static array $quests
 */
class QuestsManager
{
    private static $quests = array(
        QuestTypes::COMMENT_POST => 'site\frontend\modules\quests\components\quests\CommentPostQuest',
        QuestTypes::POST_TO_WALL => 'site\frontend\modules\quests\components\quests\PostToWallQuest',
    );

    /**
     * @param int $questType
     * @param int $event
     * @param \CActiveRecord $model
     */
    public static function handleQuest($questType, $event, $model)
    {
        if (!array_key_exists($questType, self::$quests)) {
            return;
        }

        /**
         * @var IQuest $quest
         */
        $quest = new self::$quests[$questType]();

        if (!($quest instanceof BaseQuest) || !($quest instanceof IQuest)) {
            return;
        }

        if (!in_array($event, $quest->getHandledEvents())) {
            return;
        }

        $quest->run($model, $event);
    }

    /**
     * @param int $userId
     * @param int $questType
     * @param \CActiveRecord $model
     * @param array $settings
     * @param int $endDate
     * @param string $name
     * @param string $description
     */
    public static function addQuest($userId, $questType, $model, $settings = array()
        , $endDate = null, $name = '', $description = '')
    {
        $quest = Quest::model()
            ->byUser($userId)
            ->byType($questType)
            ->byModel((new \ReflectionClass($model))->getShortName(), $model->id)
            ->find();

        if (!$quest) {
            $quest = new Quest();

            $quest->user_id = $userId;
            $quest->type_id = $questType;
            $quest->settings = \CJSON::encode($settings);
            $quest->end_date = $endDate;
            $quest->model_name = (new \ReflectionClass($model))->getShortName();
            $quest->model_id = $model->id;
            $quest->name = $name;
            $quest->description = $description;

            return $quest->save();
        }
    }
}