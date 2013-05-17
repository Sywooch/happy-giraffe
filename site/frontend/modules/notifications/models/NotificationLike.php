<?php
/**
 * Class NotificationReplyComment
 *
 * Уведомление пользователю о лайке его контента
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class NotificationLike extends Notification
{
    /**
     * @var NotificationLike
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
     * @param $recipient_id
     * @param $articles
     * @param $likes_count
     */
    public function create($recipient_id, $articles, $likes_count)
    {
        $this->recipient_id = (int)$recipient_id;
        $this->insert(array(
            'articles' => $articles,
            'count' => (int)$likes_count
        ));
    }

    /**
     * @return NotificationLike
     */
    public static function model()
    {
        if (null === self::$_instance)
            self::$_instance = new self();
        return self::$_instance;
    }

    /**
     * Создает модель уведомления для удобой работы с ним
     *
     * @param $object array объект, который вернул компонент работы с базой
     * @return NotificationLike
     */
    public static function createModel($object)
    {
        $model = new NotificationLike();
        foreach ($object as $key => $value)
            $model->$key = $value;

        return $model;
    }
}