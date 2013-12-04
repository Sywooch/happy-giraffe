<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 18/11/13
 * Time: 11:03
 * To change this template use File | Settings | File Templates.
 */

class PhotoContestWidget extends CWidget
{
    public $user;

    public function run()
    {
        $criteria = new CDbCriteria(array(
            'condition' => 't.user_id = :userId AND contest.status = :active',
            'params' => array(':userId' => $this->user->id, ':active' => Contest::STATUS_ACTIVE),
            'with' => 'contest',
            'order' => 't.id DESC',
        ));
        $work = ContestWork::model()->with('contest')->find($criteria);

        if ($work !== null)
            $this->render('PhotoContestWidget', compact('work'));
    }
}