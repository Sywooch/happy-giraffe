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
        $criteria->with = 'user';
        $criteria->addCondition('avatarId IS NOT NULL');
        $activities = Activity::model()->findAll($criteria);

        $users = array_map(function($activity) {
            return $activity->user;
        }, $activities);

        $this->render('ActivityUsersWidget', compact('users'));
    }
}