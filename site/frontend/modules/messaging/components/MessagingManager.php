<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 4/26/13
 * Time: 11:19 AM
 * To change this template use File | Settings | File Templates.
 */
class MessagingManager
{
    public static function unreadMessagesCount($userId)
    {
        return MessagingMessageUser::model()->count('user_id = :user_id AND `read` = 0', array(':user_id' => $userId));
    }
}
