<?php

namespace site\frontend\modules\quests\components;

use site\frontend\modules\comments\modules\contest\components\ContestManager;
use site\frontend\modules\quests\models\Quest;

/**
 * @static array $quests
 * @static QuestsManaged $instance
 *
 * @property Quest $quest;
 *
 * @property int $userId
 * @property int $questType
 * @property \CActiveRecord $model
 * @property array $settings
 * @property int $endDate
 * @property string $name
 * @property string $description
 */
class QuestsManager
{
    private static $quests = array(
        QuestTypes::COMMENT_POST => 'site\frontend\modules\quests\components\quests\CommentPostQuest',
        QuestTypes::POST_TO_WALL => 'site\frontend\modules\quests\components\quests\PostToWallQuest',
    );

    private static $instance;

    public $quest;

    private $userId;
    private $questType;
    private $model;
    private $settings;
    private $endDate;
    private $name;
    private $description;

    /**
     * @return QuestsManager
     */
    public static function getInstance()
    {
        if (!QuestsManager::$instance) {
            QuestsManager::$instance = new QuestsManager();
        }

        return QuestsManager::$instance;
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
    public function init($userId, $questType, $model, $settings = array(),
                         $endDate = null, $name = '', $description = '')
    {
        $this->userId = $userId;
        $this->questType = $questType;
        $this->model = $model;
        $this->settings = $settings;
        $this->endDate = $endDate;
        $this->name = $name;
        $this->description = $description;
    }

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

        if (!($quest instanceof BaseQuest)) {
            return;
        }

        if (!in_array($event, $quest->getHandledEvents())) {
            return;
        }

        return $quest->run($model, $event);
    }

    /**
     * @param int $userId
     * @param int $questType
     * @param \CActiveRecord $model
     * @param array $settings
     * @param int $endDate
     * @param string $name
     * @param string $description
     *
     * @return bool
     */
    public static function addQuest($userId, $questType, $model, $settings = array(),
                                    $endDate = null, $name = '', $description = '')
    {
        self::getInstance()->init($userId, $questType, $model,
            $settings, $endDate, $name, $description);

        if ($questType == QuestTypes::POST_TO_WALL) {
            return self::getInstance()->addPostToWallQuest();
        }

        if (!self::getInstance()->getQuest()) {
            return self::getInstance()->createQuest();
        }

        return true;
    }

    /**
     * Квесты добавления постов на стену в социалки могут быть множественными
     * и дополнительно првоеряюстя на настройки.
     *
     * @return bool
     */
    public function addPostToWallQuest()
    {
        if ($quests = $this->getAllQuests()) {
            foreach ($quests as $quest) {
                $settings = \CJSON::decode($quest->settings);

                if (isset($this->settings['social_service']) && $this->settings['social_service'] == $settings['social_service']) {
                    return true;
                }
            }
        }

        return $this->createQuest();
    }

    /**
     * @return Quest
     */
    public function getQuest()
    {
        if (!$this->quest) {
            $this->quest = Quest::model()
                ->byUser($this->userId)
                ->byType($this->questType)
                ->byModel((new \ReflectionClass($this->model))->getShortName(), $this->model->id)
                ->find();
        }

        return $this->quest;
    }

    /**
     * @return Quest[]
     */
    public function getAllQuests()
    {
        return Quest::model()
            ->resetScope()
            ->byUser($this->userId)
            ->byType($this->questType)
            ->byModel((new \ReflectionClass($this->model))->getShortName(), $this->model->id)
            ->findAll();
    }

    /**
     * @return bool
     */
    public function createQuest()
    {
        $quest = new Quest();

        $quest->user_id = $this->userId;
        $quest->type_id = $this->questType;
        $quest->settings = \CJSON::encode($this->settings);
        $quest->end_date = $this->endDate;
        $quest->model_name = (new \ReflectionClass($this->model))->getShortName();
        $quest->model_id = $this->model->id;
        $quest->name = $this->name;
        $quest->description = $this->description;

        return $quest->save();
    }
}