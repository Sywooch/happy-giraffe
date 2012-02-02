<?php

class OnlineUsersCommand extends CConsoleCommand
{
    public function actionIndex()
    {
        $rpl = Yii::app()->comet;

        $list = $rpl->cmdOnline();
        Yii::app()->db->createCommand()
            ->update('user', array('online' => '0'));
        foreach ($list as $user) {
            echo "User online: {$user}\n";
            Yii::app()->db->createCommand()
                ->update('user', array('online' => '1'), "id IN (SELECT user_id from message_cache WHERE cache = \"{$user}\")");
        }


        $pos = 0;
        while (1) {
            foreach ($rpl->cmdWatch($pos) as $event) {
                if ($event['event'] == 'online'){
                    Yii::app()->db->createCommand()
                        ->update('user', array('online' => '1'), "id IN (SELECT user_id from message_cache WHERE cache = \"{$event['id']}\")");
                }elseif ($event['event'] == 'offline'){
                    Yii::app()->db->createCommand()
                        ->update('user', array('online' => '0'), "id IN (SELECT user_id from message_cache WHERE cache = \"{$event['id']}\")");
                }
//                echo "Received: {$event['event']} - {$event['id']} - {$event['pos']}\n";
                $pos = $event['pos'];
            }
            sleep(10);
        }
    }
}
