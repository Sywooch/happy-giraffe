<?php
/**
 * @author Никита
 * @date 14/07/15
 */

namespace site\frontend\modules\som\modules\activity\widgets;


use site\frontend\modules\som\modules\activity\models\Activity;

class ActivityUsersWidget extends \CWidget
{
    const USERS_COUNT = 36;

    public function run()
    {
        $criteria = new \CDbCriteria();
        $criteria->group = 't.userId';
        $criteria->limit = self::USERS_COUNT;
        $activities = Activity::model()->findAll($criteria);

        $usersIds = array_map(function($activity) {
            return $activity->userId;
        }, $activities);

        $criteria2 = new \CDbCriteria();
        $criteria2->addInCondition('t.id', $usersIds);
        $users = \User::model()->findAll($criteria2);
        $this->render('ActivityUsersWidget', compact('users'));
    }
}