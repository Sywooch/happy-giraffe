<?php
/**
 * @author Никита
 * @date 29/03/16
 */

namespace site\frontend\modules\som\modules\qa\behaviors;

use site\frontend\modules\analytics\models\PageView;
use site\frontend\modules\notifications\behaviors\BaseBehavior;
use site\frontend\modules\notifications\models\Entity;
use site\frontend\modules\notifications\models\Notification;
use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaCategory;
use site\frontend\modules\som\modules\qa\models\QaQuestion;
use site\frontend\modules\specialists\models\SpecialistGroup;

class NotificationBehavior extends BaseBehavior
{
    /** @var QaAnswer */
    public $owner;

    /** Ответ на вопрос от специалиста */
    /**@var int PEDIATRICIAN_TYPE Обычный ответ*/
    const PEDIATRICIAN_TYPE = 15;

    /**@var int ANSWER_BY_PEDIATRICIAN Ответ педиатра*/
    const ANSWER_BY_PEDIATRICIAN = 17;
    /**@var int ANSWER_TO_ADDITIONAL Ответ на уточняющий вопрос*/
    const ANSWER_TO_ADDITIONAL = 18;
    /**@var int ADDITIONAL Утвочняющий вопрос*/
    const ADDITIONAL = 19;

    /**
     * Ответ на вопрос ???
     *
     * @see Notification::TYPE_ANSWER
     */
    const TYPE = 10;

    public function afterSave($event)
    {
        /** @var QaAnswer $answer */
        $answer = $this->owner;
        /** @var \site\frontend\modules\som\modules\qa\models\QaQuestion $question */
        $question =  $answer->question;

        if ($answer->isNewRecord && $question->sendNotifications) {
            $this->addNotification($answer, $question);
        }

        if ($answer->isRemoved == 1) {
            /**
             * @var Notification[] $signals
             */
            $signals = Notification::model()->byEntity($question)->findAll();

            foreach ($signals as &$signal) {
                $readEntityDeleted = $signal->readEntities && $this->removeEntity($signal->readEntities, $answer);
                $unreadEntityDeleted = $signal->unreadEntities && $this->removeEntity($signal->unreadEntities, $answer);
                if ($readEntityDeleted || $unreadEntityDeleted) {
                    if ((count($signal->readEntities) + count($signal->unreadEntities)) == 0) {
                        $signal->delete();
                    } else {
                        $signal->save();
                    }
                }
            }
        }

        return parent::afterSave($event);
    }

    protected function removeEntity(&$entities, $model)
    {
        foreach ($entities as $k => $entity) {
            if ($entity->id == $this->owner->id && $entity->class == get_class($model)) {
                unset($entities[$k]);
                return true;
            }
        }
        return false;
    }

    /**
     * @param QaAnswer $model
     * @param QaQuestion $question
     */
    protected function addNotification(QaAnswer $model, QaQuestion $question)
    {
        $type = $this->getType($model, $question);
        $notification = $this->findOrCreateNotification(get_class($question), $question->id, $question->authorId, $type, array($model->authorId, $model->user->avatarUrl));

        $notification->entity->tooltip = $question->title;

        $entity = new Entity($model);
        $entity->userId = $model->authorId;
        $entity->title = $model->text;
        $entity->url = $question->url;
        $notification->unreadEntities[] = $entity;
        $notification->save();
    }

    /**
     * @param QaAnswer $answer
     * @param QaQuestion $question
     *
     * @return int
     */
    private function getType(QaAnswer $answer, QaQuestion $question) {
        $type = $question->categoryId == QaCategory::PEDIATRICIAN_ID ? self::PEDIATRICIAN_TYPE : self::TYPE;

        if ($type == self::TYPE) {
            return $type;
        }

        if ($answer->author->isSpecialistOfGroup(SpecialistGroup::DOCTORS)) {
            $type = self::ANSWER_BY_PEDIATRICIAN;
        }

        if ($answer->isAnswerToAdditional()) {
            $type = self::ANSWER_TO_ADDITIONAL;
        }

        if ($answer->isAdditional()) {
            $type = self::ADDITIONAL;
        }

        return $type;
    }
}