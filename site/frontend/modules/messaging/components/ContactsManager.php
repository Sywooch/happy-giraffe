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
    const TYPE_SEARCH = 4;
    const TYPE_ONE = 5;
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
		// Проверим, что тип разрешён для данной функции
		if(!in_array($type, array(self::TYPE_ALL, self::TYPE_NEW, self::TYPE_ONLINE, self::TYPE_FRIENDS_ONLINE)))
		{
			return array();
		}
		
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
	public static function searchContacts($userId, $search, $limit, $offset = 0)
	{
		$sql = self::getSql(self::TYPE_SEARCH);

		$search = str_replace(explode(" ", "% \" ' ?"), "", $search);
		$search = explode(" ", $search);
		// Если слов больше двух, то мы точно ничего не найдём в базе
		// А если их нет, то и искать смысла нет
		if (count($search) > 2 || count($search) == 0)
		{
			return array();
		}
		elseif (count($search) == 2)
		{
			$regexp = '(u.first_name LIKE CONCAT(:like0, "%") AND u.last_name LIKE CONCAT(:like1, "%")) OR (u.first_name LIKE CONCAT(:like1, "%") AND u.last_name LIKE CONCAT(:like0, "%"))';
		}
		else
		{
			$regexp = 'u.first_name LIKE CONCAT(:like0, "%") OR u.last_name LIKE CONCAT(:like0, "%")';
		}

		$sql = str_replace('{searchCondition}', $regexp, $sql);
		$command = Yii::app()->db->createCommand($sql);
		$command->bindValue(':user_id', $userId, PDO::PARAM_INT);
		$command->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
		$command->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
		foreach ($search as $k => $v)
		{
			$command->bindValue(':like' . $k, $v, PDO::PARAM_STR);
		}
		$rows = $command->queryAll();

		$contacts = array();
		foreach ($rows as $row)
		{
			$contacts[] = self::populateContact($row);
		}
		return $contacts;
	}
	
	public static function getContactByUserId($userId, $interlocutorId)
	{
		$sql = self::getSql(self::TYPE_ONE);
		$command = Yii::app()->db->createCommand($sql);
		$command->bindValue(':user_id', $userId, PDO::PARAM_INT);
		$command->bindValue(':interlocutor_id', (int) $interlocutorId, PDO::PARAM_INT);
		$row = $command->queryRow();

		return $row ? self::populateContact($row) : null;
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
                    SELECT COUNT(DISTINCT mu.message_id)
                    FROM messaging__threads_users tu
                    # Получение количества непрочитанных сообщений
                    INNER JOIN messaging__messages m ON m.thread_id = tu.thread_id AND m.author_id != tu.user_id
                    INNER JOIN messaging__messages_users mu ON m.id = mu.message_id AND mu.dtime_read IS NULL AND mu.dtime_delete IS NULL AND mu.user_id = tu.user_id
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

        return (int)Yii::app()->db->createCommand($sql)->queryScalar(array(':user_id' => $userId));
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
                      u.last_active, # Дата последней активности
                      t.id AS tId, # ID Диалога
                      tu.hidden, # Видимость диалога
                      p.id AS pId, # ID аватара
                      p.fs_name, # Аватар
                      UNIX_TIMESTAMP(t.updated) AS updated, # Дата последнего обновления диалога
					  SUM(IF(m.author_id != tu.user_id AND mu.dtime_read IS NULL AND mu.dtime_delete IS NULL AND mu.message_id IS NOT NULL, 1, 0)) AS unreadCount, # Количество непрочитанных сообщений
                      f.id IS NOT NULL AS isFriend, # Является ли другом
                      fr1.id IS NOT NULL AS hasOutgoingRequest, # Имеет ли исходящий запрос в друзья
                      fr2.id IS NOT NULL AS hasIncomingRequest # Имеет ли входящий запрос в друзья
                    FROM messaging__threads_users tu
                    # Получение id собеседника
                    INNER JOIN messaging__threads_users tu2 ON tu.thread_id = tu2.thread_id AND tu2.user_id != tu.user_id
                    # Получение информации о собеседнике
                    INNER JOIN users u ON tu2.user_id = u.id
                    # Получение информации о диалоге
                    INNER JOIN messaging__threads t ON tu.thread_id = t.id
                    # Получение количества непрочитанных сообщений
                    RIGHT JOIN messaging__messages m ON m.thread_id = t.id
                    JOIN messaging__messages_users mu ON m.id = mu.message_id AND mu.user_id = tu.user_id AND mu.dtime_delete IS NULL
                    # Получение аватара
                    LEFT OUTER JOIN album__photos p ON u.avatar_id = p.id
                    # Является ли другом
                    LEFT OUTER JOIN friends f ON f.user_id = tu.user_id AND f.friend_id = u.id
                    # Находится ли в черном списке
                    LEFT OUTER JOIN blacklist b ON b.user_id = tu.user_id AND b.blocked_user_id = u.id
                    # Имеет исходящий запрос в друзья
                    LEFT OUTER JOIN friend_requests fr1 ON fr1.from_id = u.id AND fr1.to_id = tu.user_id AND fr1.status = 'pending'
                    # Имеет входящий запрос в друзья
                    LEFT OUTER JOIN friend_requests fr2 ON fr2.from_id = tu.user_id AND fr2.to_id = u.id AND fr2.status = 'pending'
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
                      u.last_active, # Дата последней активности
                      t.id AS tId, # ID Диалога
                      tu.hidden, # Видимость диалога
                      p.id AS pId, # ID аватара
                      p.fs_name, # Аватар
                      UNIX_TIMESTAMP(t.updated) AS updated, # Дата последнего обновления диалога
                      COUNT(mu.message_id) AS unreadCount, # Количество непрочитанных сообщений
                      f.id IS NOT NULL AS isFriend, # Является ли другом
                      fr1.id IS NOT NULL AS hasOutgoingRequest, # Имеет ли исходящий запрос в друзья
                      fr2.id IS NOT NULL AS hasIncomingRequest # Имеет ли входящий запрос в друзья
                    FROM messaging__threads_users tu
                    # Получение id собеседника
                    INNER JOIN messaging__threads_users tu2 ON tu.thread_id = tu2.thread_id AND tu2.user_id != tu.user_id
                    # Получение информации о собеседнике
                    INNER JOIN users u ON tu2.user_id = u.id
                    # Получение информации о диалоге
                    INNER JOIN messaging__threads t ON tu.thread_id = t.id
                    # Получение количества непрочитанных сообщений
                    LEFT OUTER JOIN messaging__messages m ON m.thread_id = t.id AND m.author_id != tu.user_id
                    LEFT OUTER JOIN messaging__messages_users mu ON m.id = mu.message_id AND mu.dtime_read IS NULL AND mu.dtime_delete IS NULL AND mu.user_id = tu.user_id
                    # Получение аватара
                    LEFT OUTER JOIN album__photos p ON u.avatar_id = p.id
                    # Является ли другом
                    LEFT OUTER JOIN friends f ON f.user_id = tu.user_id AND f.friend_id = u.id
                    # Находится ли в черном списке
                    LEFT OUTER JOIN blacklist b ON b.user_id = tu.user_id AND b.blocked_user_id = u.id
                    # Имеет исходящий запрос в друзья
                    LEFT OUTER JOIN friend_requests fr1 ON fr1.from_id = u.id AND fr1.to_id = tu.user_id AND fr1.status = 'pending'
                    # Имеет входящий запрос в друзья
                    LEFT OUTER JOIN friend_requests fr2 ON fr2.from_id = tu.user_id AND fr2.to_id = u.id AND fr2.status = 'pending'
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
                      u.last_active, # Дата последней активности
                      t.id AS tId, # ID Диалога
                      tu.hidden, # Видимость диалога
                      p.id AS pId, # ID аватара
                      p.fs_name, # Аватар
                      UNIX_TIMESTAMP(t.updated) AS updated, # Дата последнего обновления диалога
                      SUM(IF(m.author_id != tu.user_id AND mu.dtime_read IS NULL AND mu.dtime_delete IS NULL AND mu.message_id IS NOT NULL, 1, 0)) AS unreadCount, # Количество непрочитанных сообщений
                      f.id IS NOT NULL AS isFriend, # Является ли другом
                      fr1.id IS NOT NULL AS hasOutgoingRequest, # Имеет ли исходящий запрос в друзья
                      fr2.id IS NOT NULL AS hasIncomingRequest # Имеет ли входящий запрос в друзья
                    FROM messaging__threads_users tu
                    # Получение id собеседника
                    INNER JOIN messaging__threads_users tu2 ON tu.thread_id = tu2.thread_id AND tu2.user_id != tu.user_id
                    # Получение информации о собеседнике
                    INNER JOIN users u ON tu2.user_id = u.id
                    # Получение информации о диалоге
                    INNER JOIN messaging__threads t ON tu.thread_id = t.id
                    # Получение количества непрочитанных сообщений
                    RIGHT OUTER JOIN messaging__messages m ON m.thread_id = t.id
                    JOIN messaging__messages_users mu ON m.id = mu.message_id AND mu.user_id = tu.user_id AND mu.dtime_delete IS NULL
                    # Получение аватара
                    LEFT OUTER JOIN album__photos p ON u.avatar_id = p.id
                    # Является ли другом
                    LEFT OUTER JOIN friends f ON f.user_id = tu.user_id AND f.friend_id = u.id
                    # Находится ли в черном списке
                    LEFT OUTER JOIN blacklist b ON b.user_id = tu.user_id AND b.blocked_user_id = u.id
                    # Имеет исходящий запрос в друзья
                    LEFT OUTER JOIN friend_requests fr1 ON fr1.from_id = u.id AND fr1.to_id = tu.user_id AND fr1.status = 'pending'
                    # Имеет входящий запрос в друзья
                    LEFT OUTER JOIN friend_requests fr2 ON fr2.from_id = tu.user_id AND fr2.to_id = u.id AND fr2.status = 'pending'
                    WHERE tu.user_id = :user_id AND b.user_id IS NULL AND u.online = 1
                    GROUP BY u.id
                    ORDER BY t.updated DESC
                    LIMIT :limit
                    OFFSET :offset;
                ";
                break;
            case self::TYPE_FRIENDS_ONLINE:
                throw new Exception('Устарело');
                $sql = "
                    SELECT
                      u.id AS uId, # ID собеседника
                      u.first_name, # Имя собеседника
                      u.last_name, # Фамилия собеседника
                      u.gender, # Пол собеседника
                      u.online, # Онлайн-статус собеседника
                      u.last_active, # Дата последней активности
                      t.id AS tId, # ID Диалога
                      tu.hidden, # Видимость диалога
                      p.id AS pId, # ID аватара
                      p.fs_name, # Аватар
                      UNIX_TIMESTAMP(t.updated) AS updated, # Дата последнего обновления диалога
                      COUNT(mu.message_id) AS unreadCount, # Количество непрочитанных сообщений
                      1 IS NOT NULL AS isFriend, # Является ли другом
                      0 IS NOT NULL AS hasOutgoingRequest, # Имеет ли исходящий запрос в друзья
                      0 IS NOT NULL AS hasIncomingRequest # Имеет ли входящий запрос в друзья
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
                    LEFT OUTER JOIN messaging__messages_users mu ON m.id = mu.message_id AND mu.dtime_read IS NULL AND mu.user_id = tu.user_id
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
            case self::TYPE_SEARCH:
                $sql = "
                    SELECT
                      u.id AS uId, # ID собеседника
                      u.first_name, # Имя собеседника
                      u.last_name, # Фамилия собеседника
                      u.gender, # Пол собеседника
                      u.online, # Онлайн-статус собеседника
                      u.last_active, # Дата последней активности
                      t.id AS tId, # ID Диалога
                      tu.hidden, # Видимость диалога
                      p.id AS pId, # ID аватара
                      p.fs_name, # Аватар
                      UNIX_TIMESTAMP(t.updated) AS updated, # Дата последнего обновления диалога
                      SUM(IF(m.author_id != tu.user_id AND mu.dtime_read IS NULL AND mu.dtime_delete IS NULL AND mu.message_id IS NOT NULL, 1, 0)) AS unreadCount, # Количество непрочитанных сообщений
                      f.id IS NOT NULL AS isFriend, # Является ли другом
                      fr1.id IS NOT NULL AS hasOutgoingRequest, # Имеет ли исходящий запрос в друзья
                      fr2.id IS NOT NULL AS hasIncomingRequest # Имеет ли входящий запрос в друзья
                    FROM messaging__threads_users tu
                    # Получение id собеседника
                    INNER JOIN messaging__threads_users tu2 ON tu.thread_id = tu2.thread_id AND tu2.user_id != tu.user_id
                    # Получение информации о собеседнике
                    INNER JOIN users u ON tu2.user_id = u.id
                    # Получение информации о диалоге
                    INNER JOIN messaging__threads t ON tu.thread_id = t.id
                    # Получение количества непрочитанных сообщений
                    RIGHT JOIN messaging__messages m ON m.thread_id = t.id
                    JOIN messaging__messages_users mu ON m.id = mu.message_id AND mu.user_id = tu.user_id AND mu.dtime_delete IS NULL
                    # Получение аватара
                    LEFT OUTER JOIN album__photos p ON u.avatar_id = p.id
                    # Является ли другом
                    LEFT OUTER JOIN friends f ON f.user_id = tu.user_id AND f.friend_id = u.id
                    # Находится ли в черном списке
                    LEFT OUTER JOIN blacklist b ON b.user_id = tu.user_id AND b.blocked_user_id = u.id
                    # Имеет исходящий запрос в друзья
                    LEFT OUTER JOIN friend_requests fr1 ON fr1.from_id = u.id AND fr1.to_id = tu.user_id AND fr1.status = 'pending'
                    # Имеет входящий запрос в друзья
                    LEFT OUTER JOIN friend_requests fr2 ON fr2.from_id = tu.user_id AND fr2.to_id = u.id AND fr2.status = 'pending'
                    WHERE tu.user_id = :user_id AND b.user_id IS NULL AND ({searchCondition})
                    GROUP BY u.id
                    ORDER BY t.updated DESC
                    LIMIT :limit
                    OFFSET :offset;
                ";
                break;
            case self::TYPE_ONE:
                $sql = "
                    SELECT
                      u.id AS uId, # ID собеседника
                      u.first_name, # Имя собеседника
                      u.last_name, # Фамилия собеседника
                      u.gender, # Пол собеседника
                      u.online, # Онлайн-статус собеседника
                      u.last_active, # Дата последней активности
                      p.id AS pId, # ID аватара
                      p.fs_name, # Аватар
                      UNIX_TIMESTAMP(t.updated) AS updated, # Дата последнего обновления диалога
                      COUNT(mu.message_id) AS unreadCount, # Количество непрочитанных сообщений
                      f.id IS NOT NULL AS isFriend, # Является ли другом
                      fr1.id IS NOT NULL AS hasOutgoingRequest, # Имеет ли исходящий запрос в друзья
                      fr2.id IS NOT NULL AS hasIncomingRequest, # Имеет ли входящий запрос в друзья
					  b.user_id IS NOT NULL AS isBlocked # Заблокирован ли
                    FROM messaging__threads_users tu
                    # Получение собеседника по id
                    INNER JOIN messaging__threads_users tu2 ON tu.thread_id = tu2.thread_id AND tu2.user_id = :interlocutor_id
                    # Получение информации о собеседнике
                    INNER JOIN users u ON tu2.user_id = u.id
                    # Получение информации о диалоге
                    INNER JOIN messaging__threads t ON tu.thread_id = t.id
                    # Получение количества непрочитанных сообщений
                    LEFT OUTER JOIN messaging__messages m ON m.thread_id = t.id AND m.author_id != tu.user_id
                    LEFT OUTER JOIN messaging__messages_users mu ON m.id = mu.message_id AND mu.dtime_read IS NULL AND mu.dtime_delete IS NULL AND mu.user_id = tu.user_id
                    # Получение аватара
                    LEFT OUTER JOIN album__photos p ON u.avatar_id = p.id
                    # Является ли другом
                    LEFT OUTER JOIN friends f ON f.user_id = tu.user_id AND f.friend_id = u.id
                    # Находится ли в черном списке
                    LEFT OUTER JOIN blacklist b ON b.user_id = tu.user_id AND b.blocked_user_id = u.id
                    # Имеет исходящий запрос в друзья
                    LEFT OUTER JOIN friend_requests fr1 ON fr1.from_id = u.id AND fr1.to_id = tu.user_id AND fr1.status = 'pending'
                    # Имеет входящий запрос в друзья
                    LEFT OUTER JOIN friend_requests fr2 ON fr2.from_id = tu.user_id AND fr2.to_id = u.id AND fr2.status = 'pending'
                    WHERE tu.user_id = :user_id #AND b.user_id IS NULL
                    GROUP BY uId
                    LIMIT 1
					
					UNION
					
                    SELECT
                      u.id AS uId, # ID собеседника
                      u.first_name, # Имя собеседника
                      u.last_name, # Фамилия собеседника
                      u.gender, # Пол собеседника
                      u.online, # Онлайн-статус собеседника
                      u.last_active, # Дата последней активности
                      p.id AS pId, # ID аватара
                      p.fs_name, # Аватар
                      NULL AS updated, # Дата последнего обновления диалога
                      0 AS unreadCount, # Количество непрочитанных сообщений
                      f.id IS NOT NULL AS isFriend, # Является ли другом
                      fr1.id IS NOT NULL AS hasOutgoingRequest, # Имеет ли исходящий запрос в друзья
                      fr2.id IS NOT NULL AS hasIncomingRequest, # Имеет ли входящий запрос в друзья
					  b.user_id IS NOT NULL AS isBlocked # Заблокирован ли
					FROM users u
                    # Получение аватара
                    LEFT OUTER JOIN album__photos p ON u.avatar_id = u.id
                    # Является ли другом
                    LEFT OUTER JOIN friends f ON f.user_id = u.id AND f.friend_id = :user_id
                    # Находится ли в черном списке
                    LEFT OUTER JOIN blacklist b ON b.user_id = :interlocutor_id AND b.blocked_user_id = u.id
                    # Имеет исходящий запрос в друзья
                    LEFT OUTER JOIN friend_requests fr1 ON fr1.from_id = :interlocutor_id AND fr1.to_id = :user_id AND fr1.status = 'pending'
                    # Имеет входящий запрос в друзья
                    LEFT OUTER JOIN friend_requests fr2 ON fr2.from_id = :user_id AND fr2.to_id = :interlocutor_id AND fr2.status = 'pending'
					WHERE u.id = :interlocutor_id
					LIMIT 1
                ";
                break;
        }

        return $sql;
    }

    protected static function populateContact($row)
    {
		/** @todo Практически идентичная функциональность с DialogForm::userToJson */
        $user = User::model()->populateRecord(array(
            'id' => $row['uId'],
            'avatar_id' => $row['pId'],
        ));
        $user->avatar = AlbumPhoto::model()->populateRecord(array(
            'id' => $row['pId'],
            'author_id' => $row['uId'],
            'fs_name' => $row['fs_name'],
        ));

        return array(
			'id' => (int) $row['uId'],
			'firstName' => $row['first_name'],
			'lastName' => $row['last_name'],
			'gender' => (int) $row['gender'],
			'avatar' => $user->getAvatarUrl(Avatar::SIZE_MEDIUM),
			'channel' => $user->publicChannel,
			'isOnline' => (bool) $row['online'],
			'lastOnline' => DialogForm::parseDateTime($row['last_active']),
			'isFriend' => (bool) $row['isFriend'],
			'date' => (int) $row['updated'],
			'count' => (int) $row['unreadCount'],
            'hasIncomingRequest' => (bool) $row['hasIncomingRequest'],
            'hasOutgoingRequest' => (bool) $row['hasOutgoingRequest'],
            'profileUrl' => $user->getUrl(),
        );
    }

    public static function getContactsForDelivery($userId, $limit, $after = null)
    {
        $rows = MessagingMessageUser::model()->unread()->user($userId)->findAll(array(
            'select' => 'author.*, COUNT(*) AS unreadCount',
            'with' => array(
                'message' => array(
                    'joinType' => 'INNER JOIN',
                    'scopes' => array(
                        'newer' => $after,
                    ),
                    'with' => array(
                        'author' => array(
                            'with' => 'address',
                        ),
                    ),
                ),
            ),
            'limit' => $limit,
            'group' => 'author.id',
            'order' => 't.message_id ASC',
        ));

        return array_map(function($row) {
            return new MessagingContact($row->message->author, $row->unreadCount);
        }, $rows);
    }

    public static function getContactsForDeliveryCount($userId, $after = null)
    {
        return MessagingMessageUser::model()->user($userId)->unread()->count(array(
            'select' => 'COUNT(DISTINCT message.author_id) AS contactsCount', // yii требует использовать алиас, но он тут не нужен и обращения к нему нигде нет
            'with' => array(
                'message' => array(
                    'scopes' => array(
                        'newer' => $after,
                    ),
                ),
            ),
        ));
    }
}
