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
        $work = ContestWork::model()->with('contest')->find('t.user_id = :userId AND contest.status = :active', array(':userId' => $this->user->id, ':active' => Contest::STATUS_ACTIVE));

        if ($work !== null)
            $this->render('PhotoContestWidget', compact('work'));
    }
}