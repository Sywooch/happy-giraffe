<?php

namespace site\frontend\modules\som\modules\qa\behaviors;

use site\frontend\modules\notifications\behaviors\BaseBehavior;
use site\frontend\modules\som\modules\qa\components\QaManager;
use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\widgets\answers\AnswersWidget;

/**
 * Class AnswerCometBehavior
 *
 * @package site\frontend\modules\som\modules\qa\behaviors
 */
class AnswerCometBehavior extends BaseBehavior
{

    /**
     * @var boolean
     */
    private $_isRemoved;

    /**
     * @var boolean
     */
    private $_isPublished;

    /**
     * @inheritdoc
     */
    public function afterSave($event)
    {

        $answer = $this->owner;

        if ($answer->isPublished == 0)
        {
            return;
        }

        if ($answer->isNewRecord)
        {
            $this->_afterInsert($answer);
        }
        else
        {
            $this->_afterUpdate($answer);
        }

        return parent::afterSave($event);
    }

    /**
     * {@inheritDoc}
     * @see \site\frontend\modules\notifications\behaviors\BaseBehavior::beforeSave()
     */
    public function afterFind($event)
    {
        $this->_isRemoved = $this->owner->isRemoved;
        $this->_isPublished = $this->owner->isPublished;
    }

    private function _getQuestionChannelId($answer = NULL)
    {
        if (is_null($answer))
        {
            $answer = $this->owner;
        }

        if ($answer->question->category->isPediatrician())
        {
            return QaManager::getQuestionChannelId($answer->question->id);
        }

        return AnswersWidget::getChannelIdByQuestion($answer->questionId);
    }

    private function _updateCounter(QaAnswer $answer)
    {
        $count = $answer->question->getAnswersCount();

        $response = [
            'count'     => $count,
            'countText' => \Yii::t('app', 'ответ|ответа|ответов|ответа', $count)
        ];

        $this->_sendData($response, \CometModel::MP_QUESTION_UPDATE_ANSWERS_COUNT);
    }

    private function _afterInsert(QaAnswer $answer)
    {
        $this->_updateCounter($answer);
        $this->_sendData($answer->toJSON(), \CometModel::QA_NEW_ANSWER);
    }

    private function _removedAttrIsChange()
    {
        return $this->_isRemoved != $this->owner->isRemoved;
    }

    private function _publishedAttrIsChange()
    {
        return $this->_isPublished != $this->owner->isPublished;
    }

    private function _afterUpdate(QaAnswer $answer)
    {
        $data = $answer->toJSON();

        switch (TRUE)
        {
            case $this->_removedAttrIsChange():
                $type = $answer->isRemoved == 1 ? $this->_remove($answer) : $this->_restore($answer);
                break;
            case $answer->isAnswerToAdditional() && $this->_publishedAttrIsChange():
                $type = NotificationBehavior::ANSWER_TO_ADDITIONAL;
                break;
            case $answer->authorIsSpecialist() && $this->_publishedAttrIsChange():
                $type = \CometModel::QA_NEW_ANSWER;
                break;
            default:
                if ($answer->question->category->isPediatrician())
                {
                    QaManager::deleteAnswerObjectFromCollectionByAttr(['answerId' => $answer->id]);

                    $data = [
                        'status'    => true,
                        'answerId'  => $answer->id,
                        'text'      => $answer->text,
                        'isRoot'    => is_null($answer->root_id)
                    ];

                    $type = \CometModel::MP_QUESTION_ANSWER_FINISH_EDITED;
                }
                else
                {
                    $type = \CometModel::QA_EDIT_ANSWER;
                }

        }

        $this->_sendData($data, $type);
    }

    private function _restore(QaAnswer $answer)
    {
        $this->_updateCounter($answer);

        return \CometModel::QA_RESTORE_ANSWER;
    }

    private function _remove(QaAnswer $answer)
    {
        $this->_updateCounter($answer);

        return \CometModel::QA_REMOVE_ANSWER;
    }

    private function _sendData($data, $type, $channelId = NULL)
    {
        if (is_null($channelId))
        {
            $channelId = $this->_getQuestionChannelId();
        }

        $comet = new \CometModel();
        $comet->send($channelId, $data, $type);
    }

}