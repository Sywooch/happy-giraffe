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
        if (\UserAttributes::get(\Yii::app()->user->id, $this->getAttributeKey(), 0) == 1) {
            return;
        }

        $contest = CommentatorsContest::model()->active()->find();
        $participant = CommentatorsContestParticipant::model()->contest($contest->id)->user($this->userId)->find();
        $leaders = CommentatorsContestParticipant::model()->contest($contest->id)->top()->findAll(array(
            'limit' => 5,
        ));
        if ($participant !== null) {
            $this->render('ProfileWidget', compact('contest', 'participant', 'leaders'));
        }
    }

    public function getAttributeKey()
    {
        return get_class($this) . '.' . 'hide';
    }
}