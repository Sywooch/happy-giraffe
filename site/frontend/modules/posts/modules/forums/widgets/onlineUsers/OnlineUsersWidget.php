<?php
namespace site\frontend\modules\posts\modules\forums\widgets\onlineUsers;
use site\frontend\components\api\models\User;

/**
 * @author Никита
 * @date 29/10/15
 */

class OnlineUsersWidget extends \CWidget
{
    const LIMIT = 300;
    const CACHE_DURATION = 300;

    public function run()
    {
        $_users = $this->getUsers();
        $users = $_users['models'];
        $usersCount = $_users['count'];
        $guestsCount = $this->getGuestsCount();
        $this->render('view', compact('users', 'usersCount', 'guestsCount'));
    }

    protected function getGuestsCount()
    {
        $guests = \Yii::app()->comet->cmdOnlineWithCounters('guest');
        return $guests['guest'];
    }

    protected function getUsers()
    {
        $cacheId = get_class($this) . '.users';
        $value = \Yii::app()->cache->get($cacheId);
        if ($value === false) {
            $counters = \Yii::app()->comet->cmdOnlineWithCounters('onOff');
            $ids = array();
            $c = 0;
            foreach ($counters as $id => $counter) {
                if ($counter > 0 && $c <= self::LIMIT) {
                    $userId = str_replace('onOff', '', $id);
                    $ids[] = $userId;
                }
                $c++;
            }
            $value = array(
                'models' => User::model()->findAllByPk($ids),
                'count' => $c,
            );
            \Yii::app()->cache->set($cacheId, $value, self::CACHE_DURATION);
        }
        return $value;
    }
}