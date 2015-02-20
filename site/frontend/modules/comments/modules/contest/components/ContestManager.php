<?php
/**
 * @author Никита
 * @date 20/02/15
 */

namespace site\frontend\modules\comments\modules\contest\components;


use site\frontend\modules\comments\modules\contest\models\CommentatorsContest;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant;

class ContestManager
{
    public static function register($userId)
    {
        $contest = CommentatorsContest::model()->active()->find();
        if ($contest === null) {
            return false;
        }
        $alreadyParticipate = CommentatorsContestParticipant::model()->findByPk(array(
            'contestId' => $contest->id,
            'userId' => $userId,
        ))->exists();
        if ($alreadyParticipate) {
            return false;
        }
        $participant = new CommentatorsContestParticipant();
        $participant->userId = $userId;
        $participant->contestId = $contest->id;
        $participant->place = CommentatorsContestParticipant::model()->contest($contest->id)->count() + 1;
        return $participant->save();
    }
}