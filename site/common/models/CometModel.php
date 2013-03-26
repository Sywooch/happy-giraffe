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
    const TYPE_DIALOG_READ = 21;

    //moderator signals
    const TYPE_SIGNAL_UPDATE = 5;
    const TYPE_SIGNAL_EXECUTED = 8;
    const TYPE_COMMENTATOR_UPDATE_TASK = 9;
    const TYPE_COMMENTATOR_NEXT_COMMENT = 10;

    const UPDATE_BLOG = 0;
    const UPDATE_CLUB = 1;
    const UPDATE_COMMENTS = 2;
    const UPDATE_POSTS = 3;
    const UPDATE_ADDITIONAL_POSTS = 4;
    const UPDATE_COMMENTS_COUNT = 5;

    //user notifications
    const TYPE_NEW_NOTIFICATION = 1000;
    const TYPE_NEW_FRIEND_REQUEST = 1001;

    const TYPE_UPDATE_NOTIFICATIONS = 100;
    const TYPE_UPDATE_FRIEND_NOTIFICATIONS = 101;
    const TYPE_INVITES_PLUS_ONE = 102;

    const SEO_TASK_TAKEN = 200;

    const CONTENTS_LIVE = 300;

    const WHATS_NEW_UPDATE = 10000;

    public $attributes = array();
    public $type;

    /**
     * Send message to user channel across comet server
     *
     * @param $receiver
     * @param array $attributes
     * @param int $type signal type constant from CometModel
     * @return void
     * @internal param int $user_id user id who receive this message
     */
    public function send($receiver, $attributes = null, $type = null)
    {
        if ($attributes !== null)
            $this->attributes = $attributes;
        if ($type !== null)
            $this->type = $type;

        $channel_id = is_numeric($receiver) ? UserCache::GetUserCache($receiver) : $receiver;
        $this->attributes['type'] = $this->type;
        try {
            Yii::app()->comet->send($channel_id, $this->attributes);
        } catch (Exception $err) {

        }
    }

    public function sendToSeoUsers()
    {
        $user_ids = Yii::app()->db->createCommand()
            ->select('userid')
            ->from('auth__assignments')
            ->where('itemname = "moderator" OR itemname = "editor"')
            ->queryColumn();
        foreach ($user_ids as $user_id) {
            $this->send($user_id);
        }
    }
}
