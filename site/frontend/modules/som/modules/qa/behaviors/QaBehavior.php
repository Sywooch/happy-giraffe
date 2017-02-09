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
                $data = @serialize($this->owner);

                if ($data)
                {
                    $activity->data = $data;
                }
                else
                {
                    $activity->data = [
                        'url' => $this->owner->question->url,
                        'text' => $this->owner->text,
                        'content' => [
                            'title' => $this->owner->question->title,
                            'url' => $this->owner->question->url,
                            'authorId' => $this->owner->question->authorId,
                            'dtimeCreate' => $this->owner->question->dtimeCreate,
                            'cover' => false,
                        ],
                    ];
                }

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