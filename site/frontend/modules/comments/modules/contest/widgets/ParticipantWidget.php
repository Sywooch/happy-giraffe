<?php
namespace site\frontend\modules\comments\modules\contest\widgets;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant;

/**
 * @author Никита
 * @date 26/02/15
 */

class ParticipantWidget extends \CWidget
{
    public $contestId;
    public $participant;

    public function init()
    {
        return '';
        $this->participant = CommentatorsContestParticipant::model()->byContest($this->contestId)->byUser(\Yii::app()->user->id)->find();
    }

    public function run()
    {
        return '';
        if (! \Yii::app()->user->isGuest && $this->participant !== null) {
            $this->render('ParticipantWidget');
        }
    }
}