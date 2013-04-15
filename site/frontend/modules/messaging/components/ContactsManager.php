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
    public static function getContactsByUserId($userId)
    {
        $sql = "
            SELECT
                u.id AS uId, # ID собеседника
                u.first_name, # Имя собеседника
                u.last_name, # Фамилия собеседника
                u.gender, # Пол собеседника
                u.online, # Онлайн-статус собеседника
                t.id AS tId, # ID Диалога
                tu2.hidden, # Видимость диалога
                p.fs_name, # Аватар
                UNIX_TIMESTAMP(t.updated) AS updated, # Дата последнего обновления диалога
                COUNT(mu.message_id) AS unreadCount, # Количество непрочитанных сообщений
                friends.created IS NOT NULL AS isFriend # Является ли другом
            # Таблица ID всех пользователей в контактах
            FROM (
                # Пользователей, находящиеся в друзьях вне зависимости от наличия или отсутствия переписки с ними
                SELECT user1_id AS uId
                FROM friends
                WHERE user2_id = :user_id
                UNION
                SELECT user2_id AS uId
                FROM friends
                WHERE user1_id = :user_id
                UNION
                # Пользователи, с которыми когда-либо была переписка
                SELECT tu2.user_id AS uId
                FROM messaging__threads_users tu
                INNER JOIN messaging__threads_users tu2 ON tu.thread_id = tu2.thread_id AND tu2.user_id != :user_id
                WHERE tu.user_id = :user_id
            ) uIds
            # Связывание с таблицей пользователей для получения данных о собеседнике
            INNER JOIN users u ON u.id = uIds.uId
            # Связывание с таблицей друзей для установления, является ли собеседник другом
            LEFT OUTER JOIN friends ON (u.id = friends.user1_id AND friends.user2_id = :user_id) OR (u.id = friends.user2_id AND friends.user1_id = :user_id)
            # Связывание с таблицей участников диалога для получения ID и видимости диалога
            LEFT OUTER JOIN messaging__threads_users tu ON tu.user_id = u.id
            LEFT OUTER JOIN messaging__threads_users tu2 ON tu.thread_id = tu2.thread_id AND tu2.user_id = :user_id
            # Связывание с таблицей диалогов для получения данных о диалоге
            LEFT OUTER JOIN messaging__threads t ON t.id = tu2.thread_id
            # Связывание с таблицами сообщений и получателей сообщения для получения количества непрочитанных сообщений
            LEFT OUTER JOIN messaging__messages m ON m.thread_id = t.id AND m.author_id != :user_id
            LEFT OUTER JOIN messaging__messages_users mu ON m.id = mu.message_id AND mu.read = 0 AND mu.user_id = :user_id
            # Связывание с таблицей фотографий для получения аватара
            LEFT OUTER JOIN album__photos p ON u.avatar_id = p.id
            # Условие для корректной работы связывание с таблицей участников диалога
            WHERE tu.user_id IS NULL OR (tu.user_id IS NOT NULL AND tu2.user_id IS NOT NULL)
            GROUP BY u.id;
        ";

        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $rows = $command->queryAll();

        $contacts = array();
        foreach ($rows as $row)
            $contacts[] = self::populateContact($row);

        return $contacts;
    }

    protected static function populateContact($row)
    {
        $avatarModel = AlbumPhoto::model();

        return array(
            'user' => array(
                'id' => (int) $row['uId'],
                'firstName' => $row['first_name'],
                'lastName' => $row['last_name'],
                'gender' => $row['gender'],
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
