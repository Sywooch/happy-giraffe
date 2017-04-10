<?php
/**
 * @author Никита
 * @date 17/11/15
 */

namespace site\frontend\modules\iframe\components;

use site\frontend\modules\iframe\models\QaAnswer;
use site\frontend\modules\iframe\models\QaAnswerVote;

class VotesManager
{
    const MIN_BEST = 5;

    public static function changeVote($userId, $answerId)
    {
        $vote = QaAnswerVote::model()
            ->byAnswer($answerId)
            ->user($userId)
            ->find();
        
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
            if (!($success && $vote->answer->saveCounters(['votesCount' => $count]))) {
                throw new \CException('Vote is not saved');
            }
            self::setIsBest($vote->answer);
            $transaction->commit();
            
            return $vote->answer;
        } catch (\Exception $e) {
            $transaction->rollback();
        }
        
        return false;
    }
    
    protected static function setIsBest(QaAnswer $answer)
    {
        $criteria = clone QaAnswer::model()->question($answer->questionId)->getDbCriteria();
        $criteria->select = 'MAX(votesCount)';
        $max = \Yii::app()->db->getCommandBuilder()->createFindCommand(QaAnswer::model()->tableName(), $criteria)->execute();
        if ($answer->votesCount >= $max) {
            QaAnswer::model()->updateAll(['isBest' => new \CDbExpression('(votesCount = :max) AND (votesCount > :minBest)')], 'questionId = :questionId', [':questionId' => $answer->questionId, ':max' => $max, ':minBest' => self::MIN_BEST]);
        }
    }
}