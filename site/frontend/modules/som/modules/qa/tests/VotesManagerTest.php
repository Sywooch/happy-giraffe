<?php
/**
 * @author Никита
 * @date 15/12/15
 */

namespace site\frontend\modules\som\modules\qa\tests;

use site\frontend\modules\som\modules\qa\components\VotesManager;
use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaAnswerVote;

class VotesManagerTest extends \CTestCase
{
    const USER_ID = 12936;

    public function testVote()
    {
        $answer = QaAnswer::model()->find();
        for ($i = 0; $i < 2; $i++) {
            $answerBefore = QaAnswer::model()->findByPk($answer->id);
            $hasVoteBefore = QaAnswerVote::model()->user(self::USER_ID)->answers(array($answerBefore))->exists();
            $modifier = ($hasVoteBefore) ? -1 : 1;

            $result = VotesManager::changeVote(self::USER_ID, $answer->id);

            $answerAfter = QaAnswer::model()->findByPk($answer->id);
            $hasVoteAfter = QaAnswerVote::model()->user(self::USER_ID)->answers(array($answerBefore))->exists();

            $this->assertInstanceOf('\site\frontend\modules\som\modules\qa\models\QaAnswer', $result);
            $this->assertEquals($answerAfter->votesCount, $answerBefore->votesCount + $modifier);
            $this->assertEquals($hasVoteBefore, ! $hasVoteAfter);
        }

        $this->assertFalse(VotesManager::changeVote(self::USER_ID, 0));
    }
}