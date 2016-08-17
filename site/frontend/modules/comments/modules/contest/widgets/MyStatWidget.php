<?php

namespace site\frontend\modules\comments\modules\contest\widgets;

use site\frontend\modules\comments\modules\contest\components\ContestManager;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant;

/**
 * @property CommentatorsContestParticipant $participant
 */
class MyStatWidget extends \CWidget
{
    public $participant;

    public function run()
    {
        if (\Yii::app()->user->isGuest) {
            return;
        }

        $this->participant = CommentatorsContestParticipant::model()
            ->byContest(ContestManager::getCurrentActive()->id)
            ->byUser(\Yii::app()->user->id)
            ->with('user')
            ->find();

        if (!$this->participant) {
            if (!($this->participant = ContestManager::getCurrentActive()->addParticipant(\Yii::app()->user->id))) {
                return;
            }
        }

        $this->render('MyStatWidget');
    }
}