<?php

class OnlineUsersCommand extends CConsoleCommand
{
    public $current_day;

    public function actionIndex()
    {
        ini_set('memory_limit', -1);

        Yii::import('site.frontend.modules.scores.models.*');
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.extensions.*');
        Yii::import('site.frontend.components.*');
        Yii::import('site.common.models.mongo.*');

        $rpl = Yii::app()->comet;
        $list = $rpl->cmdOnline();
        Yii::app()->db->createCommand()
            ->update('users', array('online' => '0'));

        $users = User::model()->findAll(array('select' => 'id', 'condition' => 'online=1'));
        foreach ($users as $user) {
            Yii::app()->cache->delete('User_' . $user->id);
        }

        $this->current_day = date("Y-m-d");

        foreach ($list as $user) {
            echo "User online: {$user}\n";
            $user = $this->getUserByCache($user);
            if (empty($user))
                continue;
            $user->online = 1;
            $user->last_active = date("Y-m-d H:i:s");
            $user->save(false, array('online','last_active'));
            ScoreVisits::addTodayVisit($user->id);
        }

        $pos = 0;
        while (1) {
            $this->checkScoresForNewDay($rpl);
            foreach ($rpl->cmdWatch($pos) as $event) {
                echo $event['event'];
                if ($event['event'] == 'online') {
//                    Yii::app()->db->createCommand()
//                        ->update('user', array('online' => '1'), "id IN (SELECT user_id from message_cache WHERE cache = \"{$event['id']}\")");
//                    $userCache = UserCache::model()->find('cache = "'.$event['id'].'"');
                    $user = $this->getUserByCache($event['id']);
                    if (empty($user)) {
                        echo "user not found: {$event['id']}\n";
                        continue;
                    }
                    $user->online = 1;
                    $user->last_active = date("Y-m-d H:i:s");
                    $user->save(false, array('online','last_active'));
                    ScoreVisits::addTodayVisit($user->id);
                    $this->SendOnlineNotice($user->id, 1);

                    echo "user online: {$user->id}\n";
                } elseif ($event['event'] == 'offline') {
//                    Yii::app()->db->createCommand()
//                        ->update('user', array('online' => '0'), "id IN (SELECT user_id from message_cache WHERE cache = \"{$event['id']}\")");
                    $user = $this->getUserByCache($event['id']);
                    if (empty($user)) {
                        echo "user not found: {$event['id']}\n";
                        continue;
                    }
                    $user->online = 0;
                    $user->last_active = date("Y-m-d H:i:s", strtotime(' - 15 minutes'));
                    $user->save(false, array('online','last_active'));
                    $this->SendOnlineNotice($user->id, 0);

                    echo "user offline: {$user->id}\n";
                }
                $pos = $event['pos'];
            }
            usleep(300000);
        }
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
            'select' => array('id', 'online')
        ));
    }

    /**
     * @param int $user_id
     * @param bool $online
     */
    private function SendOnlineNotice($user_id, $online)
    {
/*        $friends = User::model()->findAll(User::getUserById($user_id)->getFriendSelectCriteria());
        //id друзей
        $friend_ids = array();
        foreach ($friends as $friend) {
            $friend_ids [] = $friend->id;
        }
        $friend_ids = array_unique($friend_ids);

        $comet = new CometModel;
        $comet->type = CometModel::TYPE_ONLINE_STATUS_CHANGE;

        $dialogs = Im::model($user_id)->getDialogs();
        foreach ($dialogs as $dialog) {
            if (isset($dialog['users'][0])) {
                $u_id = $dialog['users'][0];
                if (in_array($u_id, $friend_ids)){
                    $comet->attributes = array('dialog_id' => $dialog['id'], 'online' => $online, 'user_type' => 2);
                    foreach($friend_ids as $key => $friend_id)
                        if ($friend_id == $u_id)
                            unset($friend_ids[$key]);
                }
                else
                    $comet->attributes = array('dialog_id' => $dialog['id'], 'online' => $online, 'user_type' => 0);
                $comet->send($dialog['users'][0]);
            }
        }
        foreach ($friend_ids as $friend_id) {
            $comet->attributes = array('online' => $online, 'user_type' => 1);
            $comet->send($friend_id);
        }*/
    }

    /**
     * @param Dklab_Realplexor $rpl
     */
    public function checkScoresForNewDay($rpl)
    {
        if ($this->current_day != date("Y-m-d") && date("i") >= 15) {
            $list = $rpl->cmdOnline();
            echo "Add scores for " . count($list) . " users \n";

            foreach ($list as $user) {
                $user = $this->getUserByCache($user);
                if (empty($user))
                    continue;
                ScoreVisits::addTodayVisit($user->id);
            }

            $this->current_day = date("Y-m-d");
        }
    }
}

