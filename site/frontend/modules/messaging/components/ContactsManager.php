<?php
/**
 * Class ContactsManager
 *
 * Обработчик контактов
 *
 * @author Nikita <nikita@happy-giraffe.ru>
 * @todo Отказать от использовании Active Record модели в получении аватарки для увеличения производительности
 * @todo Не инстанцировать модель аватара для каждого кортежа отдельно
 */
class ContactsManager
{
    const TYPE_ALL = 0;
    const TYPE_NEW = 1;
    const TYPE_ONLINE = 2;
    const TYPE_FRIENDS_ONLINE = 3;
    const LIMIT = 20;

    /**
     * Получение контактов пользователя
     *
     * Возвращает список контактов. Каждый контакт представлен следующим набором свойств:
     * -ID собеседника;
     * -имя собеседника;
     * -фамилия собеседника;
     * -онлайн-статус собеседника;
     * -ID диалога;
     * -видимость диалога;
     * -дата последнего обновления диалога;
     * -количество непрочитанных сообщений;
     * -является ли собеседник другом;
     * маленький аватар.
     *
     * Контактами являются:
     * -пользователи, с которыми когда-либо была переписка;
     * -пользователи, находящиеся в друзьях вне зависимости от наличия или отсутствия переписки с ними.
     *
     * Контакты возвращаются в виде единого списка, а уже на клиенте распределяются по вкладкам.
     *
     * @static
     * @param $userId
     * @return array
     */
    public static function getContactsByUserId($userId, $type, $limit, $offset = 0)
    {
        $sql = self::getSql($type);

        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $command->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $command->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $rows = $command->queryAll();

        $contacts = array();
        foreach ($rows as $row)
            $contacts[] = self::populateContact($row);

        return $contacts;
    }

    public static function getCountByType($userId, $type)
    {
        switch ($type) {
            case self::TYPE_ALL;
                $sql = "
                    SELECT COUNT(*)
                    FROM messaging__threads_users tu
                    # Получение id собеседника
                    INNER JOIN messaging__threads_users tu2 ON tu.thread_id = tu2.thread_id AND tu2.user_id != tu.user_id
                    # Находится ли в чёрном списке
                    LEFT OUTER JOIN blacklist b ON b.user_id = tu.user_id AND b.blocked_user_id = tu2.user_id
                    WHERE tu.user_id = :user_id AND b.user_id IS NULL;
                ";
                break;
            case self::TYPE_NEW:
                $sql = "
                    SELECT COUNT(DISTINCT tu.thread_id)
                    FROM messaging__threads_users tu
                    # Получение количества непрочитанных сообщений
                    INNER JOIN messaging__messages m ON m.thread_id = tu.thread_id AND m.author_id != tu.user_id
                    INNER JOIN messaging__messages_users mu ON m.id = mu.message_id AND mu.read = 0 AND mu.user_id = tu.user_id
                    # Получение id собеседника
                    INNER JOIN messaging__threads_users tu2 ON tu.thread_id = tu2.thread_id AND tu2.user_id != tu.user_id
                    # Находится ли в чёрном списке
                    LEFT OUTER JOIN blacklist b ON b.user_id = tu.user_id AND b.blocked_user_id = tu2.user_id
                    WHERE tu.user_id = :user_id AND b.user_id IS NULL
                    GROUP BY tu.user_id;
                ";
                break;
            case self::TYPE_ONLINE:
                $sql = "
                    SELECT COUNT(*)
                    FROM messaging__threads_users tu
                    # Получение id собеседника
                    INNER JOIN messaging__threads_users tu2 ON tu.thread_id = tu2.thread_id AND tu2.user_id != :user_id
                    # Получение информации о собеседнике
                    INNER JOIN users u ON tu2.user_id = u.id
                    # Находится ли в чёрном списке
                    LEFT OUTER JOIN blacklist b ON b.user_id = tu.user_id AND b.blocked_user_id = tu2.user_id
                    WHERE tu.user_id = :user_id AND u.online = 1 AND b.user_id IS NULL
                ";
                break;
            case self::TYPE_FRIENDS_ONLINE:
                $sql = "
                    SELECT COUNT(*)
                    FROM friends f
                    # Получение информации о собеседнике
                    INNER JOIN users u ON u.id = f.friend_id
                    # Находится ли в чёрном списке
                    LEFT OUTER JOIN blacklist b ON b.user_id = f.user_id AND b.blocked_user_id = f.friend_id
                    WHERE f.user_id = :user_id AND u.online = 1;
                ";
                break;
        }

        return Yii::app()->db->createCommand($sql)->queryScalar(array(':user_id' => $userId));
    }

    protected function getSql($type) {
        switch ($type) {
            case self::TYPE_ALL:
                $sql = "
                    SELECT
                      u.id AS uId, # ID собеседника
                      u.first_name, # Имя собеседника
                      u.last_name, # Фамилия собеседника
                      u.gender, # Пол собеседника
                      u.online, # Онлайн-статус собеседника
                      t.id AS tId, # ID Диалога
                      tu.hidden, # Видимость диалога
                      p.fs_name, # Аватар
                      UNIX_TIMESTAMP(t.updated) AS updated, # Дата последнего обновления диалога
                      COUNT(mu.message_id) AS unreadCount, # Количество непрочитанных сообщений
                      f.id IS NOT NULL AS isFriend # Является ли другом
                    FROM messaging__threads_users tu
                    # Получение id собеседника
                    INNER JOIN messaging__threads_users tu2 ON tu.thread_id = tu2.thread_id AND tu2.user_id != tu.user_id
                    # Получение информации о собеседнике
                    INNER JOIN users u ON tu2.user_id = u.id
                    # Получение информации о диалоге
                    INNER JOIN messaging__threads t ON tu.thread_id = t.id
                    # Получение количества непрочитанных сообщений
                    LEFT OUTER JOIN messaging__messages m ON m.thread_id = t.id AND m.author_id != tu.user_id
                    LEFT OUTER JOIN messaging__messages_users mu ON m.id = mu.message_id AND mu.read = 0 AND mu.user_id = tu.user_id
                    # Получение аватара
                    LEFT OUTER JOIN album__photos p ON u.avatar_id = p.id
                    # Является ли другом
                    LEFT OUTER JOIN friends f ON f.user_id = tu.user_id AND f.friend_id = u.id
                    # Находится ли в черном списке
                    LEFT OUTER JOIN blacklist b ON b.user_id = tu.user_id AND b.blocked_user_id = u.id
                    WHERE tu.user_id = :user_id AND b.user_id IS NULL
                    GROUP BY u.id
                    ORDER BY t.updated DESC
                    LIMIT :limit
                    OFFSET :offset;
                ";
                break;
            case self::TYPE_NEW:
                $sql = "
                    SELECT
                      u.id AS uId, # ID собеседника
                      u.first_name, # Имя собеседника
                      u.last_name, # Фамилия собеседника
                      u.gender, # Пол собеседника
                      u.online, # Онлайн-статус собеседника
                      t.id AS tId, # ID Диалога
                      tu.hidden, # Видимость диалога
                      p.fs_name, # Аватар
                      UNIX_TIMESTAMP(t.updated) AS updated, # Дата последнего обновления диалога
                      COUNT(mu.message_id) AS unreadCount, # Количество непрочитанных сообщений
                      f.id IS NOT NULL AS isFriend # Является ли другом
                    FROM messaging__threads_users tu
                    # Получение id собеседника
                    INNER JOIN messaging__threads_users tu2 ON tu.thread_id = tu2.thread_id AND tu2.user_id != tu.user_id
                    # Получение информации о собеседнике
                    INNER JOIN users u ON tu2.user_id = u.id
                    # Получение информации о диалоге
                    INNER JOIN messaging__threads t ON tu.thread_id = t.id
                    # Получение количества непрочитанных сообщений
                    LEFT OUTER JOIN messaging__messages m ON m.thread_id = t.id AND m.author_id != tu.user_id
                    LEFT OUTER JOIN messaging__messages_users mu ON m.id = mu.message_id AND mu.read = 0 AND mu.user_id = tu.user_id
                    # Получение аватара
                    LEFT OUTER JOIN album__photos p ON u.avatar_id = p.id
                    # Является ли другом
                    LEFT OUTER JOIN friends f ON f.user_id = tu.user_id AND f.friend_id = u.id
                    # Находится ли в черном списке
                    LEFT OUTER JOIN blacklist b ON b.user_id = tu.user_id AND b.blocked_user_id = u.id
                    WHERE tu.user_id = :user_id AND b.user_id IS NULL
                    GROUP BY u.id
                    HAVING unreadCount > 0
                    ORDER BY t.updated DESC
                    LIMIT :limit
                    OFFSET :offset;
                ";
                break;
            case self::TYPE_ONLINE:
                $sql = "
                    SELECT
                      u.id AS uId, # ID собеседника
                      u.first_name, # Имя собеседника
                      u.last_name, # Фамилия собеседника
                      u.gender, # Пол собеседника
                      u.online, # Онлайн-статус собеседника
                      t.id AS tId, # ID Диалога
                      tu.hidden, # Видимость диалога
                      p.fs_name, # Аватар
                      UNIX_TIMESTAMP(t.updated) AS updated, # Дата последнего обновления диалога
                      COUNT(mu.message_id) AS unreadCount, # Количество непрочитанных сообщений
                      f.id IS NOT NULL AS isFriend # Является ли другом
                    FROM messaging__threads_users tu
                    # Получение id собеседника
                    INNER JOIN messaging__threads_users tu2 ON tu.thread_id = tu2.thread_id AND tu2.user_id != tu.user_id
                    # Получение информации о собеседнике
                    INNER JOIN users u ON tu2.user_id = u.id
                    # Получение информации о диалоге
                    INNER JOIN messaging__threads t ON tu.thread_id = t.id
                    # Получение количества непрочитанных сообщений
                    LEFT OUTER JOIN messaging__messages m ON m.thread_id = t.id AND m.author_id != tu.user_id
                    LEFT OUTER JOIN messaging__messages_users mu ON m.id = mu.message_id AND mu.read = 0 AND mu.user_id = tu.user_id
                    # Получение аватара
                    LEFT OUTER JOIN album__photos p ON u.avatar_id = p.id
                    # Является ли другом
                    LEFT OUTER JOIN friends f ON f.user_id = tu.user_id AND f.friend_id = u.id
                    # Находится ли в черном списке
                    LEFT OUTER JOIN blacklist b ON b.user_id = tu.user_id AND b.blocked_user_id = u.id
                    WHERE tu.user_id = :user_id AND b.user_id IS NULL AND u.online = 1
                    GROUP BY u.id
                    ORDER BY t.updated DESC
                    LIMIT :limit
                    OFFSET :offset;
                ";
                break;
            case self::TYPE_FRIENDS_ONLINE:
                $sql = "
                    SELECT
                      u.id AS uId, # ID собеседника
                      u.first_name, # Имя собеседника
                      u.last_name, # Фамилия собеседника
                      u.gender, # Пол собеседника
                      u.online, # Онлайн-статус собеседника
                      t.id AS tId, # ID Диалога
                      tu.hidden, # Видимость диалога
                      p.fs_name, # Аватар
                      UNIX_TIMESTAMP(t.updated) AS updated, # Дата последнего обновления диалога
                      COUNT(mu.message_id) AS unreadCount, # Количество непрочитанных сообщений
                      1 AS isFriend # Является ли другом
                    FROM friends f
                    # Получение информации о собеседнике
                    INNER JOIN users u ON f.friend_id = u.id
                    # Связывание с таблицей участников диалога для получения ID и видимости диалога
                    LEFT OUTER JOIN messaging__threads_users tu2 ON tu2.user_id = f.friend_id
                    LEFT OUTER JOIN messaging__threads_users tu ON tu.thread_id = tu2.thread_id AND tu.user_id = f.user_id
                    # Получение информации о диалоге
                    LEFT OUTER JOIN messaging__threads t ON tu.thread_id = t.id
                    # Получение количества непрочитанных сообщений
                    LEFT OUTER JOIN messaging__messages m ON m.thread_id = t.id AND m.author_id != tu.user_id
                    LEFT OUTER JOIN messaging__messages_users mu ON m.id = mu.message_id AND mu.read = 0 AND mu.user_id = tu.user_id
                    # Получение аватара
                    LEFT OUTER JOIN album__photos p ON u.avatar_id = p.id
                    # Находится ли в черном списке
                    LEFT OUTER JOIN blacklist b ON b.user_id = tu.user_id AND b.blocked_user_id = u.id
                    WHERE f.user_id = :user_id AND tu.user_id IS NOT NULL AND b.user_id IS NULL AND u.online = 1
                    GROUP BY u.id
                    ORDER BY t.updated DESC
                    LIMIT :limit
                    OFFSET :offset;
                ";
                break;
        }

        return $sql;
    }

    protected static function populateContact($row)
    {
        $avatarModel = AlbumPhoto::model();

        return array(
            'user' => array(
                'id' => (int) $row['uId'],
                'firstName' => $row['first_name'],
                'lastName' => $row['last_name'],
                'gender' => (int) $row['gender'],
                'avatar' => $avatarModel->populateRecord(array(
                    'author_id' => $row['uId'],
                    'fs_name' => $row['fs_name'],
                ))->getAvatarUrl('small'),
                'online' => (bool) $row['online'],
                'isFriend' => (bool) $row['isFriend'],
            ),
            'thread' => ($row['tId'] === null) ? null : array(
                'id' => (int) $row['tId'],
                'updated' => (int) $row['updated'],
                'unreadCount' => (int) $row['unreadCount'],
                'hidden' => (bool) $row['hidden'],
            ),
        );
    }
}
