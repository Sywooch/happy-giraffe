<?php
namespace site\frontend\modules\comments\modules\contest\widgets;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant;

/**
 * @author Никита
 * @date 26/02/15
 */

class ParticipantWidget extends \CWidget
{
    public $userId;
    public $contestId;

    public function run()
    {
        $participant = CommentatorsContestParticipant::model()->contest($this->contestId)->user($this->userId)->find();
        if ($participant !== null) {
            $this->render('ParticipantWidget', compact('participant'));
        }
    }
}