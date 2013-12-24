<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 18/11/13
 * Time: 17:03
 * To change this template use File | Settings | File Templates.
 */

class MyContestWorkWidget extends CWidget
{
    public $contestId;

    public function run()
    {
        $work = Yii::app()->user->isGuest ? null : ContestWork::model()->with('contest')->find('user_id = :userId AND contest_id = :contestId', array(':userId' => Yii::app()->user->id, ':contestId' => $this->contestId));
        if ($work !== null) {
            $collection = new ContestPhotoCollection(array('contestId' => $this->contestId));
            $this->render('MyContestWorkWidget/work', compact('work', 'collection'));
        } elseif ($work->contest->status == Contest::STATUS_ACTIVE)
            $this->render('MyContestWorkWidget/button');
    }
}