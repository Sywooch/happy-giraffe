<?php

class OnlineUsersCommand extends CConsoleCommand
{

    public $current_day;
    private $rpl;

    public function init()
    {
        parent::init();
        ini_set('memory_limit', -1);

        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.extensions.*');
        Yii::import('site.frontend.components.*');
        Yii::import('site.common.models.mongo.*');
        Yii::import('site.frontend.modules.scores.components.*');
        Yii::import('site.frontend.modules.scores.models.*');
        Yii::import('site.frontend.modules.scores.models.input.*');
        Yii::import('site.frontend.modules.onlineManager.widgets.OnlineManagerWidget');

        // Выставляем всем пользователям оффлайн
        Yii::app()->db->createCommand()
            ->update('users', array('online' => '0'));
        // Мистика начало
        $users = User::model()->findAll(array('select' => 'id', 'condition' => 'online=1'));
        foreach ($users as $user)
        {
            Yii::app()->cache->delete('User_' . $user->id);
        }
        // Мистика конец
        // Устанавливаем текущую дату (необходимо для достижений)
        $this->current_day = date("Y-m-d");

        // Выставлем онлайн тем, кто сейчас онлайн
        $this->rpl = Yii::app()->comet;
        $list = $this->rpl->cmdOnline();
        foreach ($list as $channel)
        {
            if (self::checkUserChannel($channel))
            {
                $user = $this->getUserByCache($channel);
                if (!empty($user))
                {
                    $this->updateOnline($user, 1);
                }
            }
        }
    }

    public function actionIndex()
    {
        // начинаем с 0
        $pos = 0;
        // стартуем бесконечный цикл
        while (1)
        {
            // начисление достижений
            $this->checkScoresForNewDay();
            // смотрим все события
            foreach ($this->rpl->cmdWatch($pos) as $event)
            {
                // двигаем курсор
                $pos = $event['pos'];
                // выводим событие и id канала
                echo "\t" . $event['event'] . " " . $event['id'] . "\n";
                if (self::checkUserChannel($event['id']))
                {
                    $user = $this->getUserByCache($event['id']);
                    if (!empty($user))
                    {
                        // событие на вход/выход пользователя
                        $online = $event['event'] == 'online' ? 1 : 0;
                        // обновляем базу
                        $this->updateOnline($user, $online);
                        // рассылаем всем, что пользователь вошёл/вышел
                        $this->SendOnlineNotice($user);
                    }
                }
            }
            // немого спим
            usleep(300000);
        }
    }

    /**
     *
     * @param User $user
     */
    private function updateOnline($user, $online)
    {
        $user->online = $online;
        $user->last_active = date("Y-m-d H:i:s");
        $user->save(false, array('online', 'last_active'));
        echo $user->id . " " . $online . "\n";
        if ($online == 1)
        {
            ScoreVisits::getInstance()->addTodayVisit($user->id);
        }
        User::clearCache($user->id);
    }

    /**
     * @param $cache
     * @return User|null
     */
    private function getUserByCache($cache)
    {
        $userCache = UserCache::model()->find('cache = "' . $cache . '"');
        if (empty($userCache))
            return null;
        return User::model()->find(array(
            'condition' => 'id=' . $userCache->user_id,
            //'select' => array('id', 'online')
        ));
    }

    /**
     * @param User $user
     * @param bool $online
     */
    private function SendOnlineNotice($user)
    {
        $comet = new CometModel();
        $comet->send($user->publicChannel, array('user' => OnlineManagerWidget::userToJson($user)), CometModel::TYPE_ONLINE_STATUS_CHANGE);
        echo 'sending ' . $user->publicChannel . ' ' . CometModel::TYPE_ONLINE_STATUS_CHANGE . "\n";
    }

    /**
     * Начисление достижений
     */
    public function checkScoresForNewDay()
    {
        if ($this->current_day != date("Y-m-d") && date("i") >= 15)
        {
            $list = $this->rpl->cmdOnline();
            echo "Add scores for " . count($list) . " users \n";

            foreach ($list as $user)
            {
                $user = $this->getUserByCache($user);
                if (!empty($user))
                {
                    Scoring::visit($user->id);
                }
            }

            $this->current_day = date("Y-m-d");
        }
    }

    public static function checkUserChannel($channel)
    {
        return strpos($channel, UserCache::CHANNEL_PREFIX) === 0;
    }

}

