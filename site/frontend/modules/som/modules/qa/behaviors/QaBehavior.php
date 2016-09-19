<?php

namespace site\frontend\modules\som\modules\qa\behaviors;

use site\frontend\modules\som\modules\activity\behaviors\ActivityBehavior;
use site\frontend\modules\som\modules\activity\models\api\Activity;
use site\frontend\modules\som\modules\qa\models\QaQuestion;
use site\frontend\modules\som\modules\qa\models\QaAnswer;
use Aws\CloudFront\Exception\Exception;

/**
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
     * @return \site\frontend\modules\som\modules\activity\models\api\Activity Модель активности, заполненная данными
     */
    public function getActivityModel()
    {
        $activity = new Activity();
        $activity->dtimeCreate = (int) $this->owner->dtimeCreate;
        $activity->userId = (int) $this->owner->authorId;

        switch (TRUE)
        {
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
                    'url' => $this->owner->question->url,
                    'text' => $this->owner->text,
                    'content' => [
                        'title'         => $this->owner->question->title,
                        'url'           => $this->owner->question->url,
                        'authorId'      => $this->owner->question->authorId,
                        'dtimeCreate'   => $this->owner->question->dtimeCreate,
                        'cover'         => false,
                    ],
                ];
                $activity->typeId = 'comment';
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