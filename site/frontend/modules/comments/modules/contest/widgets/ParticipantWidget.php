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
        $this->participant = CommentatorsContestParticipant::model()->contest($this->contestId)->user(\Yii::app()->user->id)->find();
    }

    public function run()
    {
        if (! \Yii::app()->user->isGuest && $this->participant !== null) {
            $this->render('ParticipantWidget');
        }
    }
}