<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 23/04/14
 * Time: 14:53
 * To change this template use File | Settings | File Templates.
 */

class OnlineManager
{
    public static function online(User $user, $login = false)
    {
        if ($user->online == 1) {
            return false;
        }

        ScoreVisits::getInstance()->addTodayVisit($user->id);
        User::clearCache($user->id);

        $user->online = 1;
        $user->last_active = date("Y-m-d H:i:s");

        if ($login) {
            $user->login_date = date('Y-m-d H:i:s');
            $user->last_ip = $_SERVER['REMOTE_ADDR'];
        }

        self::sendOnline($user);
        return $user->update(array('online', 'last_active', 'login_date', 'last_ip'));
    }

    public static function offline(User $user)
    {
        if ($user->online == 0) {
            return false;
        }

        User::clearCache($user->id);

        $user->online = 0;

        self::sendOnline($user);
        return $user->update(array('online'));
    }

    protected static function sendOnline(User $user)
    {
        $comet = new CometModel();
        $comet->send($user->publicChannel, array('user' => OnlineManagerWidget::userToJson($user)), CometModel::TYPE_ONLINE_STATUS_CHANGE);
    }
}