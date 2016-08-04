<?php

namespace site\frontend\modules\comments\modules\contest\widgets;

use site\frontend\modules\comments\modules\contest\components\ContestManager;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant;

/**
 * @property int $limit
 * @property iny $count
 * @property CommentatorsContestParticipant[] $leaders
 */
class LeadersWidget extends \CWidget
{
    public $limit = 10;
    public $count;
    public $leaders = array();

    public function run()
    {
        $this->leaders = CommentatorsContestParticipant::model()
            ->byContest(ContestManager::getCurrentActive()->id)
            ->orderByScore()
            ->with('user')
            ->findAll(array(
                'limit' => $this->limit,
            ));

        $this->count = count($this->leaders);

        $this->render('LeadersWidget');
    }
}