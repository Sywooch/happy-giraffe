<?php

namespace site\frontend\modules\som\modules\qa\components;

use site\frontend\modules\som\modules\qa\models\QaCTAnswer;
use site\frontend\modules\som\modules\qa\models\QaCTAnswerVote;

class QaCTVoteManager extends BaseVoteManager
{
    protected static $_prepared = [];

    public function loadAnswerData($answers, $userId)
    {
        $votes = QaCTAnswerVote::model()->byUserId($userId)->byAnswerIds(array_map(function (QaCTAnswer $answer) {
            return $answer->id;
        }, $answers))->findAll();

        foreach ($votes as $vote) {
            if (!isset(static::$_prepared[$vote->id_answer])) {
                static::$_prepared[$vote->id_answer] = [];
            }

            if (!in_array($vote->id_user, static::$_prepared[$vote->id_answer])) {
                static::$_prepared[$vote->id_answer][] = $vote->id_user;
            }
        }
    }

    public function isVoted($answerId, $userId)
    {
        return isset(static::$_prepared[$answerId]) && in_array($userId, static::$_prepared[$answerId]);
    }
}
