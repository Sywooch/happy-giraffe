<?php

namespace site\frontend\modules\som\modules\qa\behaviors;

use site\frontend\modules\som\modules\activity\behaviors\ActivityBehavior;
use site\frontend\modules\som\modules\activity\models\api\Activity;
use site\frontend\modules\som\modules\qa\models\QaCategory;
use site\frontend\modules\som\modules\qa\models\QaCTAnswer;
use site\frontend\modules\som\modules\qa\models\QaQuestion;
use site\frontend\modules\som\modules\qa\models\QaAnswer;
use Aws\CloudFront\Exception\Exception;

/**
 * @property QaAnswer|QaCTAnswer|QaQuestion $owner
 *
 * @author Emil Vililyaev
 */
class QaBehavior extends ActivityBehavior
{
    /**
     * Метод, возвращающий уникальный идентификатор сущности,
     * которой соответствует активность.
     *
     * @return string Результат md5 от идентификатора сущности
     */
    public function getActivityId()
    {
        return md5($this->owner->id);
    }

    /**
     * {@inheritDoc}
     * @see \site\frontend\modules\som\modules\activity\behaviors\ActivityBehavior::afterSave()
     */
    public function afterSave($event)
    {
        $this->updateActivity();
        return parent::afterSave($event);
    }

    /**
     * Update Activity->data
     */
    public function updateActivity()
    {
        try
        {
            /*@var $activity Activity */
            $activity = \site\frontend\modules\som\modules\activity\models\Activity::model()->find('hash = "' . $this->getActivityId() . '"');
            if ($activity
                && $this->owner instanceof QaAnswer
                && $activity->typeId == \site\frontend\modules\som\modules\activity\models\Activity::TYPE_ANSWER_PEDIATRICIAN
                )
            {
                $data = @json_encode(['attributes' => $this->owner->getAttributes()]);
                $activity->data = is_null($data) ? $activity->data : $data;
                $result = $activity->save();
            }
        }
        catch (\Exception $ex)
        {
            \CommentLogger::model()->addToLog('activity update', $ex->getMessage());
            return;
        }


    }

    /**
     *
     * @return bool|\site\frontend\modules\som\modules\activity\models\api\Activity Модель активности, заполненная данными
     */
    public function getActivityModel()
    {
        if (
            $this->owner instanceof QaQuestion
            &&
            !is_null($this->owner->category)
            &&
            $this->owner->category->isPediatrician()
        )
        {
            return false;
        }

        $activity = new Activity();
        $activity->dtimeCreate = (int) $this->owner->dtimeCreate;
        $activity->userId = (int) $this->owner->authorId;

        switch (true) {
            case $this->owner instanceof QaQuestion :
                $activity->data = [
                    'title' => $this->owner->title,
                    'url' => $this->owner->url,
                    'text' => $this->owner->text,
                ];

                $activity->typeId = 'question';
                break;
            case $this->owner instanceof QaAnswer :
                $activity->data = [
                    'attributes' => $this->owner->getAttributes(),
                ];

                if ($this->owner->question->categoryId == QaCategory::PEDIATRICIAN_ID) {
                    $activity->typeId = \site\frontend\modules\som\modules\activity\models\Activity::TYPE_ANSWER_PEDIATRICIAN;
                } else {
                    $activity->typeId = \site\frontend\modules\som\modules\activity\models\Activity::TYPE_COMMENT;
                }
                break;
            default:
                $activity->typeId = 'post';
                break;
        }

        return $activity;
    }

    /**
     *
     * @return boolean true - модель удалена и надо удалить активность, false - модель есть и при необходимости, надо создать активность.
     */
    public function getIsRemoved()
    {
        return isset($this->owner->isRemoved) ? $this->owner->isRemoved : 0;
    }

}