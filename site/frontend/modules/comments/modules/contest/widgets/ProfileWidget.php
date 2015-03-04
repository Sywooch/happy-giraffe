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
    public $contest;
    public $participant;

    public function init()
    {
        $this->contest = CommentatorsContest::model()->active()->find();
        if ($this->contest) {
            $this->participant = CommentatorsContestParticipant::model()->contest($this->contest->id)->user($this->userId)->find();
        }
    }

    public function run()
    {
        if ($this->participant !== null) {
            $this->render('ProfileWidget');
        }
    }
}