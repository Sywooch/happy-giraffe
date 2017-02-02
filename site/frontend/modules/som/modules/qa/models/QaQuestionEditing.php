<?php

namespace site\frontend\modules\som\modules\qa\models;
use site\frontend\modules\som\modules\qa\components\QaManager;

/**
 * Class QaQuestionEditing
 * @package site\frontend\modules\som\modules\qa\models
 *
 * @author Sergey Gubarev
 */
class QaQuestionEditing extends \EMongoDocument
{

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
        return 'questions_editing';
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
    protected function afterDelete()
    {
        $channelId = QaManager::getQuestionChannelId($this->questionId);

        $question = QaManager::getQuestion($this->questionId);
        $question->usePurifiedCache = FALSE;

        (new \CometModel())->send($channelId, $question->toJSON(), \CometModel::MP_QUESTION_FINISH_EDITED_BY_OWNER);

        return parent::afterDelete();
    }
}