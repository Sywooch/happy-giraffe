<?php

namespace site\frontend\modules\iframe\models;

/**
 * @property int $id_user
 * @property int $id_answer
 */
class QaCTAnswerVote extends \HActiveRecord
{
    public function byUserId($userId)
    {
        $this->getDbCriteria()->addColumnCondition(['id_user' => $userId]);

        return $this;
    }

    public function byAnswerIds($answerIds)
    {
        $this->getDbCriteria()->addInCondition('id_answer', (array) $answerIds);

        return $this;
    }

    public function tableName()
    {
        return 'qa__answers_votes_new';
    }


}