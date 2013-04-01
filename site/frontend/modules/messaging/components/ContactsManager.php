<?php
/**
 * Class ContactsManager
 *
 * Обработчик контактов
 *
 * @author Nikita <nikita@happy-giraffe.ru>
 */
class ContactsManager
{
    /**
     * Получение контактов пользователя
     *
     * Возвращает список контактов, с которыми у пользователя когда-либо была переписка
     *
     * @static
     * @param $userId
     * @return array
     */
    public static function getThreadContactsByUserId($userId)
    {
        $sql = "
            SELECT
                tu.hidden AS threadHiddenStatus,
                tu.thread_id AS threadId,
                tu2.user_id AS interlocutorId,
                u.first_name AS interlocutorFirstName,
                u.last_name AS interlocutorLastName,
                u.online AS interlocutorOnlineStatus,
                t.updated AS threadUpdated,
                COUNT(mu.message_id) AS threadUnreadCount
            FROM messaging__threads_users tu
            INNER JOIN messaging__threads_users tu2 ON tu.thread_id = tu2.thread_id AND tu2.user_id != :user_id
            INNER JOIN users u ON u.id = tu2.user_id
            INNER JOIN messaging__threads t ON t.id = tu.thread_id
            LEFT OUTER JOIN messaging__messages m ON m.thread_id = tu.thread_id
            LEFT OUTER JOIN messaging__messages_users mu ON m.id = mu.message_id AND mu.read = 0 AND mu.user_id = :user_id
            WHERE tu.user_id = :user_id
            GROUP BY tu.thread_id;
        ";

        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $rows = $command->queryAll();
        return $rows;
    }

    public static function getFriendsContactsByUserId()
}
