<?php
/**
 * Author: alexk984
 * Date: 07.03.12
 */
class CometModel extends CComponent
{
    const TYPE_ONLINE_STATUS_CHANGE = 3;

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

    const TYPE_SCORES_EARNED = 23;

    //user notifications
    const TYPE_NEW_NOTIFICATION = 1000;
    const TYPE_NEW_FRIEND_REQUEST = 1001;

    const TYPE_UPDATE_NOTIFICATIONS = 100;
    const TYPE_UPDATE_FRIEND_NOTIFICATIONS = 101;
    const TYPE_INVITES_PLUS_ONE = 102;

    const SEO_TASK_TAKEN = 200;

    const CONTENTS_LIVE = 300;

    const WHATS_NEW_UPDATE = 10000;

    const MESSAGING_INTERLOCUTOR_TYPING = 2010;
    const MESSAGING_MESSAGE_READ = 2011;
    const MESSAGING_MESSAGE_ADDED = 2020;
    const MESSAGING_MESSAGE_EDITED = 2021;
    const MESSAGING_MESSAGE_DELETED = 2030;
    const MESSAGING_MESSAGE_CANCELLED = 2040;
    const MESSAGING_MESSAGE_RESTORED = 2050;
    const MESSAGING_THREAD_DELETED = 2060;
    const MESSAGING_THREAD_RESTORED = 2070;
    const MESSAGING_CONTACT_ADDED = 2071;
    const MESSAGING_CONTACT_DELETED = 2072;
	/**
	 * Добавление/удаление пользователя в список друзей, и/или в чёрный список
	 */
    const MESSAGING_USER_UPDATED = 2073;
	// Обновление счётчиков
    const MESSAGING_UPDATE_COUNTERS = 2080;
    const MESSAGING_COUNT_CONTACT = 2083;

    const SETTING_UPDATED = 3000;
    const BLACKLIST_ADDED = 3001;
    const BLACKLIST_REMOVED = 3002;
    const AVATAR_UPLOADED = 3003;

    const FRIEND_REQUEST_SENT = 4000;
    const FRIEND_REQUEST_DECLINED = 4001;
    const FRIEND_ADDED = 4010;
    
    const NOTIFY_ADDED = 5001;
    const NOTIFY_READED = 5002;
    const NOTIFY_UPDATED = 5003;

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
