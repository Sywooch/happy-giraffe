<?php
/**
 * Управляет статусами пользователей на сайте
 */

class OnlineManager
{
    /**
     * Помечает пользователя как онлайн
     *
     * @param User $user    Пользователь
     * @param bool $login   Вызван ли метод из аутентификацией пользователя на сайте
     * @return bool         Удалось ли применить статус
     */
    public static function online(User $user, $login = false)
    {
        if ($user->online == 1) {
            return true;
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

    /**
     * Помечает пользователя как оффлайн
     *
     * @param User $user    Пользователь
     * @return bool         Удалось ли применить статус
     */
    public static function offline(User $user)
    {
        if ($user->online == 0) {
            return true;
        }

        User::clearCache($user->id);

        $user->online = 0;

        self::sendOnline($user);
        return $user->update(array('online'));
    }

    /**
     * Сообщает статус в публичный канал пользователя
     *
     * @param User $user    Пользователь
     */
    protected static function sendOnline(User $user)
    {
        $comet = new CometModel();
        $comet->send($user->publicChannel, array('user' => OnlineManagerWidget::userToJson($user)), CometModel::TYPE_ONLINE_STATUS_CHANGE);
    }
}