<?php
/**
 * @author Никита
 * @date 12/10/16
 */

namespace site\frontend\modules\specialists\modules\pediatrician\widgets\summary;


use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaAnswerVote;

class SummaryWidget extends \CWidget
{
    public $userId;
    
    public function run()
    {
        $this->render('summary', [
            'usersCount' => $this->getUsersCount(),
            'likesCount' => $this->getLikesCount(),
        ]);
    }

    public function getUsersCount()
    {
        return QaAnswer::model()->user($this->userId)->with('question')->count([
            'select' => 'COUNT(DISTINCT question.authorId) AS c',
        ]);
    }

    public function getLikesCount()
    {
        return QaAnswerVote::model()->count([
            'with' => [
                'answer' => [
                    'scopes' => [
                        'user' => [$this->userId],
                    ],
                    'joinType' => 'INNER JOIN',
                ],
            ]
        ]);
    }
}