<?php
/**
 * Уведомление о том что обсуждение темы продолжается. Отправляется тем кто уже комментировал
 * запись/фото/видео, после того как будет написано еще NEW_COMMENTS_COUNT комментариев.
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */

class NotificationDiscussContinue extends Notification
{
    /**
     * Количество новых комментариев, после которого показываем уведомление
     * о продолжении дискуссии
     */
    const NEW_COMMENTS_COUNT = 10;
    /**
     * @var NotificationDiscussContinue
     */
    private static $_instance;

    public $type = self::DISCUSS_CONTINUE;
    public $entity;
    public $entity_id;
    public $last_read_comment_id;

    public function __construct()
    {
    }

    /**
     * @return NotificationDiscussContinue
     */
    public static function model()
    {
        if (null === self::$_instance)
            self::$_instance = new self();
        return self::$_instance;
    }

    /**
     * Создаем уведомление о продолжении дискуссии
     *
     * @param $recipient_id int
     * @param $comment Comment комментарий
     * @param $last_read_comment_id int
     */
    public function create($recipient_id, $comment, $last_read_comment_id)
    {
        $this->recipient_id = (int)$recipient_id;

        parent::insert(array(
            'entity' => $comment->entity,
            'entity_id' => (int)$comment->entity_id,
            'last_read_comment_id' => (int)$last_read_comment_id,
        ));
    }

    /**
     * Создает модель уведомления для удобой работы с ним
     *
     * @param $object array объект, который вернул компонент работы с базой
     * @return NotificationDiscussContinue
     */
    public static function createModel($object)
    {
        $model = new NotificationDiscussContinue;
        foreach ($object as $key => $value)
            $model->$key = $value;

        return $model;
    }
}