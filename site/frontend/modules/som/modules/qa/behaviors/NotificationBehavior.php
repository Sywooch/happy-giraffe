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
use site\frontend\modules\som\modules\qa\components\QaManager;

/**
 * @property QaAnswer $owner
 */
class NotificationBehavior extends BaseBehavior
{
    /** Ответ на вопрос от специалиста */

    /**@var int PEDIATRICIAN_TYPE Обычный ответ */
    const PEDIATRICIAN_TYPE = 15;
    /**@var int ANSWER_BY_PEDIATRICIAN Ответ педиатра */
    const ANSWER_BY_PEDIATRICIAN = 17;
    /**@var int ANSWER_TO_ADDITIONAL Ответ на уточняющий вопрос */
    const ANSWER_TO_ADDITIONAL = 18;
    /**@var int ADDITIONAL Утвочняющий вопрос */
    const ADDITIONAL = 19;
    /**@var int ANSWER_IN_BRANCH Комментарий в ветку овтетов*/
    const ANSWER_IN_BRANCH = 20;

    /**
     * Ответ на вопрос ??? - это в те категории, которые не мой педиатр.
     *
     * @see Notification::TYPE_ANSWER
     */
    const TYPE = 10;

    public function afterSave($event)
    {
        $answer = $this->owner;
        $question = $answer->question;

        if ($answer->isNewRecord && (bool)$question->sendNotifications) {
            // Если паблишед, отправяем сигнал сразу. Иначе этим будет заниматься отдельный воркер
            if ($answer->isPublished) {
                $this->sendNotification();
            }
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

    public function sendNotification()
    {
        return $this->addNotification($this->owner, $this->owner->question);
    }

    /**
     * @param QaAnswer $model
     * @param QaQuestion $question
     */
    protected function addNotification(QaAnswer $model, QaQuestion $question)
    {
        /*@todo импортированно с site\frontend\modules\som\modules\qa\behaviors\CometBehavior. Зачем отдельный седнер для ответов на доп вопрос спросить у Сергея  */
        if ($model->isAnswerToAdditional())
        {
            $questionChannelId = QaManager::getQuestionChannelId($model->question->id);

            $comet = new \CometModel();
            $comet->send($questionChannelId, $model->toJSON(), NotificationBehavior::ANSWER_TO_ADDITIONAL);
            //return;
        }

        $type = $this->getType($model, $question);

        if ($type == self::ANSWER_IN_BRANCH) {
            $userId = $model->root->authorId;
        } else {
            $userId = $question->authorId;
        }

        $notification = $this->findOrCreateNotification(get_class($question), $question->id, $userId, $type, array($model->authorId, $model->user->avatarUrl));

        $notification->entity->tooltip = $question->title;

        if ($type == self::ANSWER_IN_BRANCH) {
            $notification->entity->userId = $question->authorId;
        }

        $entity = new Entity($model);
        $entity->userId = $model->authorId;
        $entity->title = $model->text;
        $entity->tooltip = $question->title;

        $notification->unreadEntities[] = $entity;
        $notification->save();
    }

    /**
     * @param QaAnswer $answer
     * @param QaQuestion $question
     *
     * @return int
     *
     * @fixme думаю надо разобраться с типами в целом, а так же исключить PEDIATRICIAN_TYPE (10), т.к. он разбит на несколько других типов
     */
    private function getType(QaAnswer $answer, QaQuestion $question)
    {
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

        if ($answer->isCommentToBranch()) {
            $type = self::ANSWER_IN_BRANCH;
        }

        return $type;
    }
}