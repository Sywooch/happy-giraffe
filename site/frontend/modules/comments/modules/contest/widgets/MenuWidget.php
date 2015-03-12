<?php
/**
 * @author Никита
 * @date 06/03/15
 */

namespace site\frontend\modules\comments\modules\contest\widgets;


use site\frontend\modules\comments\modules\contest\models\CommentatorsContest;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant;

class MenuWidget extends \CWidget
{
    public $userId;
    public $contest;
    public $participant;

    public function run()
    {
        $this->contest = CommentatorsContest::model()->active()->find();
        if ($this->contest !== null) {
            $this->participant = CommentatorsContestParticipant::model()->contest($this->contest->id)->user($this->userId)->find();
            $this->render('MenuWidget');
        }
    }
}