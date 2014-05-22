<?php
/**
 * Class NotificationReplyComment
 *
 * Уведомление пользователю о лайке его контента
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class NotificationLikes extends NotificationSummary
{
    /**
     * @var NotificationLikes
     */
    private static $_instance;
    public $type = self::NEW_LIKE;
    /**
     * топ-10 лайковых статей за день, вида:
     * 'entity' => класс статьи,
     * 'entity_id' => id статьи,
     * 'count' => суммарное кол-во лайков
     *
     * @var array
     */
    public $articles = array();

    public function __construct()
    {
    }

    /**
     * Создаение уведомления о новых лайках. Раз в день в 10 утра
     *
     * @param int $recipient_id
     * @param array $articles топ-статьи по лайкам
     * @param int $count суммарное кол-во лайков
     */
    public function create($recipient_id, $articles, $count)
    {
        $this->recipient_id = (int)$recipient_id;
        $this->insert(array(
            'articles' => $articles,
            'count' => (int)$count
        ));
    }

    /**
     * @return NotificationLikes
     */
    public static function model()
    {
        if (null === self::$_instance)
            self::$_instance = new self();
        return self::$_instance;
    }
}