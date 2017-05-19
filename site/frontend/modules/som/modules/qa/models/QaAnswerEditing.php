<?php

namespace site\frontend\modules\som\modules\qa\models;

use site\frontend\modules\specialists\modules\pediatrician\components\QaManager;

/**
 * Class QaAnswerEditing
 * @package site\frontend\modules\som\modules\qa\models
 *
 * @author Sergey Gubarev
 */
class QaAnswerEditing extends \EMongoDocument
{

    /**
     * ID ответа
     *
     * @var integer
     */
    public $answerId;

    /**
     * ID вопроса
     *
     * @var integer
     */
    public $questionId;

    /**
     * @inheritdoc
     */
    public function getCollectionName()
    {
        return 'answers_editing';
    }

    /**
     * @param string $className
     * @return \EMongoDocument
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @inheritdoc
     */
    protected function afterSave()
    {
        $channelId = QaManager::getQuestionChannelId($this->answerId);

        (new \CometModel())->send($channelId, null, \CometModel::MP_ANSWER_START_EDITING_BY_OWNER);

        return parent::afterSave();
    }

    /**
     * @inheritdoc
     */
    protected function afterDelete()
    {
        $channelId           = \site\frontend\modules\som\modules\qa\components\QaManager::getQuestionChannelId($this->questionId);
        $specialistChannelId = QaManager::getQuestionChannelId($this->answerId);

        $answer = QaAnswer::model()->findByPk($this->answerId);

        $comet = new \CometModel();
        $comet->send($channelId,           ['answerId' => $this->answerId, 'isRoot' => is_null($answer->root_id)], \CometModel::MP_QUESTION_ANSWER_FINISH_EDITED);
        $comet->send($specialistChannelId, ['text' => \site\common\helpers\HStr::truncate($answer->text, 150)], \CometModel::MP_ANSWER_FINISH_EDITING_BY_OWNER);

        return parent::afterDelete();
    }

}