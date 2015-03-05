<?php
namespace site\frontend\modules\comments\modules\contest\widgets;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContest;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant;

/**
 * @author Никита
 * @date 03/03/15
 */

class MyGiraffeWidget extends \CWidget
{
    public function run()
    {
        if (\UserAttributes::get(\Yii::app()->user->id, $this->getAttributeKey(), 0) == 1) {
            return;
        }
        $contest = CommentatorsContest::model()->active()->find();
        if ($contest !== null) {
            $leaders = CommentatorsContestParticipant::model()->contest($contest->id)->top()->findAll(array(
                'limit' => 5,
            ));
            $this->render('MyGiraffeWidget', compact('contest', 'leaders'));
        }
    }
    public function getAttributeKey()
    {
        return 'ProfileWidget.hide';
    }
}