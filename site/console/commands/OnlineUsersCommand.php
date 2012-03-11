<?php

class OnlineUsersCommand extends CConsoleCommand
{
    public function actionIndex()
    {
        Yii::import('site.frontend.modules.im.models.*');
        Yii::import('site.frontend.modules.im.components.*');

        $rpl = Yii::app()->comet;
        $list = $rpl->cmdOnline();
        Yii::app()->db->createCommand()
            ->update('user', array('online' => '0'));

        $users = User::model()->findAll(array('select'=>'id','condition'=>'online=1'));
        foreach ($users as $user) {
            Yii::app()->cache->delete('User_' . $user->id);
        }

        foreach ($list as $user) {
            echo "User online: {$user}\n";
            $user = $this->getUserByCache($user);
            if (empty($user))
                continue;
            $user->online = 1;
            $user->save();
//            Yii::app()->db->createCommand()
//                ->update('user', array('online' => '1'), "id IN (SELECT user_id from message_cache WHERE cache = \"{$user}\")");
        }

        $pos = 0;
        while (1) {
            foreach ($rpl->cmdWatch($pos) as $event) {
                if ($event['event'] == 'online'){
//                    Yii::app()->db->createCommand()
//                        ->update('user', array('online' => '1'), "id IN (SELECT user_id from message_cache WHERE cache = \"{$event['id']}\")");
//                    $userCache = MessageCache::model()->find('cache = "'.$event['id'].'"');
                    $user = $this->getUserByCache($event['id']);
                    if (empty($user)) {echo "user not found: {$event['id']}\n"; continue;}
                    $user->online = 1;
                    $user->save();
                    $this->SendOnlineNotice($rpl, $user->id, 1);

                    echo "user online: {$user->id}\n";
                }elseif ($event['event'] == 'offline'){
//                    Yii::app()->db->createCommand()
//                        ->update('user', array('online' => '0'), "id IN (SELECT user_id from message_cache WHERE cache = \"{$event['id']}\")");
                    $user = $this->getUserByCache($event['id']);
                    if (empty($user)) {echo "user not found: {$event['id']}\n"; continue;}
                    $user->online = 0;
                    $user->save();
                    $this->SendOnlineNotice($rpl, $user->id, 0);

                    echo "user offline: {$user->id}\n";
                }
                $pos = $event['pos'];
            }
            sleep(5);
        }
    }

    /**
     * @param $cache
     * @return User|null
     */
    private function getUserByCache($cache){
        $userCache = MessageCache::model()->find('cache = "'.$cache.'"');
        if (empty($userCache))
            return null;
        return User::model()->find(array(
            'condition'=>'id='.$userCache->user_id,
            'select'=>array('id', 'online')
        ));
    }

    /**
     * @param Dklab_Realplexor $rpl
     * @param int $user_id
     * @param bool $online
     */
    private function SendOnlineNotice($rpl, $user_id, $online){
        $dialogs = Im::model($user_id)->getDialogs();
        foreach ($dialogs as $dialog) {
            $rpl->send(MessageCache::GetUserCache($dialog['users'][0]), array(
                'dialog_id' => $dialog['id'],
                'type' => MessageLog::TYPE_ONLINE_STATUS_CHANGE,
                'online' => $online
            ));
        }
    }
}

