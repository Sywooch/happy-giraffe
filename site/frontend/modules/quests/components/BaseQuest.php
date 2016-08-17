<?php

namespace site\frontend\modules\quests\components;

use site\frontend\modules\quests\models\Quest;

/**
 * @property int $userId;
 * @property \CActiveRecord $model;
 * @property int $type;
 * @property Quest $instance;
 */
abstract class BaseQuest
{
    protected $userId;
    protected $model;
    protected $type;
    protected $instance;

    protected function getUserId()
    {
        if (!$this->userId) {
            $this->userId = \Yii::app()->user->id;
        }

        return $this->userId;
    }

    protected abstract function getType();
    protected abstract function getQuest();
}