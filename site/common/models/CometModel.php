<?php
/**
 * Author: alexk984
 * Date: 07.03.12
 */
class CometModel extends CComponent
{
    const TYPE_NEW_MESSAGE = 1;
    const TYPE_MESSAGE_READ = 2;
    const TYPE_ONLINE_STATUS_CHANGE = 3;
    const TYPE_USER_TYPING = 4;

    const TYPE_SIGNAL_UPDATE = 5;
    const TYPE_SIGNAL_EXECUTED = 8;

    const TYPE_UPDATE_NOTIFICATIONS = 100;
    const TYPE_UPDATE_FRIEND_NOTIFICATIONS = 101;
    const TYPE_INVITES_PLUS_ONE = 102;

    const SEO_TASK_TAKEN = 200;

    public $attributes = array();
    public $type;

    /**
     * Send message to user channel across comet server
     *
     * @param int $user_id user id who receive this message
     * @param array $attributes
     * @param int $type signal type constant from CometModel
     */
    public function send($user_id, $attributes = null, $type = null){
        if ($attributes !== null)
            $this->attributes = $attributes;
        if ($type !== null)
            $this->type = $type;

        $channel_id = UserCache::GetUserCache($user_id);
        $this->attributes['type'] = $this->type;
        Yii::app()->comet->send($channel_id, $this->attributes);
    }

    public function sendToSeoUsers()
    {
        $user_ids = Yii::app()->db_seo->createCommand()
            ->select('userid')
            ->from('auth__assignments')
            ->where('itemname = "moderator" OR itemname = "editor"')
            ->queryColumn();
        foreach ($user_ids as $user_id){
            $this->send($user_id);
        }
    }
}
