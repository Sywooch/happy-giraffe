<?php
/**
 * @author Никита
 * @date 17/11/15
 */

namespace site\frontend\modules\som\modules\qa\components;


use site\frontend\modules\som\modules\qa\models\QaAnswer;
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
            if (! ($success && $vote->answer->saveCounters(array('votesCount' => $count)))) {
                throw new \CException('Vote is not saved');
            }
            self::setIsBest($vote->answer);
            $transaction->commit();
            return $vote->answer;
        } catch(\Exception $e)
        {
            $transaction->rollback();
        }
        return false;
    }

    public static function setIsBest(QaAnswer $answer)
    {
        $criteria = clone QaAnswer::model()->question($answer->questionId)->getDbCriteria();
        $criteria->select = 'MAX(votesCount)';
        $max = \Yii::app()->db->getCommandBuilder()->createFindCommand(QaAnswer::model()->tableName(), $criteria)->execute();
        if ($answer->votesCount >= $max) {
            QaAnswer::model()->updateAll(array('isBest' => new \CDbExpression('(votesCount = :max)')), 'questionId = :questionId AND votesCount > 0', array(':questionId' => $answer->questionId, ':max' => $max));
        }
    }
}