<?php
namespace site\frontend\modules\posts\modules\forums\widgets\onlineUsers;
use site\frontend\components\api\models\User;

/**
 * @author Никита
 * @date 29/10/15
 */

class OnlineUsersWidget extends \CWidget
{
    public $limit = 40;

    public function run()
    {
        $users = $this->getUsers();
        if (! empty($users)) {
            $this->render('view', compact('users'));
        }
    }

    /**
     * @todo необходимо получать пользователей через API (SOA)
     */
    protected function getUsers()
    {
        $criteria = new \CDbCriteria();
        $criteria->limit = $this->limit;
        $criteria->compare('online', '1');
        $criteria->addCondition('avatarId IS NOT NULL');
        return \User::model()->findAll($criteria);
    }
}