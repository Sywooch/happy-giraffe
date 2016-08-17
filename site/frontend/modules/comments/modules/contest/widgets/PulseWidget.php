<?php

namespace site\frontend\modules\comments\modules\contest\widgets;

use site\frontend\modules\comments\modules\contest\components\ContestManager;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContestComment;

class PulseWidget extends \CWidget
{
    public $limit = 5;
    public $comments = array();

    public function run()
    {
        /**
         * @var CommentatorsContestComment[] $contestComments
         */
        $contestComments = CommentatorsContestComment::model()
            ->orderDesc()
            ->byContest(ContestManager::getCurrentActive()->id)
            ->existingComments()
            ->with('comment')
            ->findAll(array(
                'limit' => $this->limit,
            ));

        foreach ($contestComments as $c) {
            $this->comments[] = $c->comment;
        }

        $this->render('PulseWidget');
    }
}