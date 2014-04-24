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
    public static function unreadMessagesCount($userId, $condition='', $params = array())
    {
        $criteria = MessagingMessageUser::model()->getCommandBuilder()->createCriteria($condition, $params);
        return MessagingMessageUser::model()->user($userId)->unread()->count($criteria);
    }
}
