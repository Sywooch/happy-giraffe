<?php
/**
 * @author Никита
 * @date 17/11/15
 */

namespace site\frontend\modules\som\modules\qa\components;


use site\frontend\modules\som\modules\qa\models\QaAnswerVote;

class VotesManager
{
    public static function changeVote($userId, $answerId)
    {
        $vote = QaAnswerVote::model()->findByPk(compact('userId', 'answerId'));
        $transaction = \Yii::app()->db->beginTransaction();
        try {
            if ($vote === null) {
                $vote = new QaAnswerVote();
                $vote->attributes = compact('userId', 'answerId');
                $success = $vote->save();
                $count = 1;
            } else {
                $success = $vote->delete();
                $count = -1;
            }
            $success = $success && $vote->answer->saveCounters(array('votesCount', $count));
            return $success;
        } catch(\Exception $e)
        {
            $transaction->rollback();
        }
        return false;
    }
}