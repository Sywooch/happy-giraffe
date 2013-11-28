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
        if (! Yii::app()->user->isGuest) {
            $work = ContestWork::model()->find('user_id = :userId AND contest_id = :contestId', array(':userId' => Yii::app()->user->id, ':contestId' => $this->contestId));
            if ($work !== null) {
                $collection = new ContestPhotoCollection(array('contestId' => $this->contestId));
                $this->render('MyContestWorkWidget', compact('work', 'collection'));
            }
        }
    }
}