<?php
/**
 * @author Никита
 * @date 03/03/15
 */

namespace site\frontend\modules\comments\modules\contest\widgets;


use site\frontend\modules\comments\modules\contest\models\CommentatorsContest;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant;

class ProfileWidget extends \CWidget
{
    public $userId;

    public function run()
    {
        $contest = CommentatorsContest::model()->active()->find();
        $participant = CommentatorsContestParticipant::model()->contest($contest->id)->user($this->userId)->find();
        if ($participant !== null) {
            $this->render('ProfileWidget', compact('contest', 'participant', 'leaders'));
        }
    }
}