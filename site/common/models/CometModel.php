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

    const COMMENTS_NEW = 2510;
    const COMMENTS_UPDATE = 2520;
    const COMMENTS_DELETE = 2530;
    const COMMENTS_RESTORE = 2540;

    const SETTING_UPDATED = 3000;
    const BLACKLIST_ADDED = 3001;
    const BLACKLIST_REMOVED = 3002;
    const AVATAR_UPLOADED = 3003;

    const FRIEND_REQUEST_SENT = 4000;
    const FRIEND_REQUEST_DECLINED = 4001;
    const FRIEND_ADDED = 4010;

    const NOTIFY_ADDED = 5001;
    const NOTIFY_UPDATED = 5003;
    const NOTIFY_DELETED = 5004;

    const QA_VOTE = 6001;
    const QA_NEW_ANSWER = 6002;
    const QA_REMOVE_ANSWER = 6003;
    const QA_RESTORE_ANSWER = 6004;
    const QA_EDIT_ANSWER = 6005;

    const BLOGS_EFIR_NEW_POST = 228;

    /**
     * @var integer MP_QUESTION_ANSWER_EDITED Статус-код: Редактируется ответ
     * @author Sergey Gubarev
     */
    const MP_QUESTION_ANSWER_EDITED = 7001;

    /**
     * @var integer MP_QUESTION_ANSWER_FINISH_EDITED Статус-код: Редактируется ответ завершено/отменено
     * @author Sergey Gubarev
     */
    const MP_QUESTION_ANSWER_FINISH_EDITED = 7000;

    /**
     * @var integer MP_QUESTION_UPDATE_ANSWERS_COUNT Статус-код: Обновить общее кол-во ответов
     * @author Sergey Gubarev
     */
    const MP_QUESTION_UPDATE_ANSWERS_COUNT = 7002;

    /**
     * @var integer MP_QUESTION_QUESTION_REMOVED_BY_OWNER Статус-код: Автор удаляет свой вопрос
     * @author Sergey Gubarev
     */
    const MP_QUESTION_REMOVED_BY_OWNER = 7003;

    /**
     * @var integer MP_QUESTION_QUESTION_REMOVED_BY_OWNER Статус-код: Автор редактирует свой вопрос
     * @author Sergey Gubarev
     */
    const MP_QUESTION_EDITED_BY_OWNER = 7004;

    /**
     * @var integer MP_QUESTION_FINISH_EDITED_BY_OWNER Статус-код: Автор закончил редактировать свой вопрос
     * @author Sergey Gubarev
     */
    const MP_QUESTION_FINISH_EDITED_BY_OWNER = 7005;

    /**
     * @var integer MP_ANSWER_FINISH_EDITING_BY_OWNER Статус-код: Автор закончил редактировать свой ответ
     * @author Sergey Gubarev
     */
    const MP_ANSWER_FINISH_EDITING_BY_OWNER = 7006;

    /**
     * @var integer MP_ANSWER_START_EDITING_BY_OWNER Статус-код: Автор начал редактировать свой ответ
     * @author Sergey Gubarev
     */
    const MP_ANSWER_START_EDITING_BY_OWNER = 7007;


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
            /*@todo хз как решать, иначе не приходят все запросы в браузер */
            usleep(400000);// 100ms
            \Yii::app()->comet->send($channel_id, $this->attributes);
        } catch (Exception $err) {
            echo $err->getMessage();
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
