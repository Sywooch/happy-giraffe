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
        $criteria->limit = self::USERS_COUNT;
        $criteria->addCondition('avatarId IS NOT NULL');
        $criteria->join = 'JOIN (SELECT * FROM som__activity AS tt ORDER BY tt.dtimeCreate desc LIMIT 500) AS tmp ON (tmp.userid = t.id)';
        $criteria->group = 't.id';
        $criteria->order = 'tmp.dtimeCreate desc';
        $users = \site\frontend\modules\users\models\User::model()->findAll($criteria);

        $this->render('ActivityUsersWidget', compact('users'));
    }

}
