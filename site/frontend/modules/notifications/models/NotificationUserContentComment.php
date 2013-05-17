<?php
/**
 * Class NotificationUserContentComment
 *
 * Уведомление пользователю о новом комментарии
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class NotificationUserContentComment extends NotificationGroup
{
    /**
     * @var Notification
     */
    private static $_instance;
    public $type = self::USER_CONTENT_COMMENT;

    public function __construct()
    {
    }

    /**
     * @return NotificationUserContentComment
     */
    public static function model()
    {
        if (null === self::$_instance)
            self::$_instance = new self();
        return self::$_instance;
    }

    /**
     * Создаем уведомление о новом комментарии. Если уведомление к этому посту уже создавалось и еще не было
     * прочитано, то добавляем в него новый комментарий и увеличиваем кол-во нотификаций
     *
     * @param $recipient_id int id пользователя, который должен получить уведомление
     * @param $comment Comment комментарий
     */
    public function create($recipient_id, $comment)
    {
        $this->recipient_id = (int)$recipient_id;
        $this->entity = $comment->entity;
        $this->entity_id = (int)$comment->entity_id;

        parent::create($comment->id);
    }

    /**
     * Создает модель уведомления для удобой работы с ним
     *
     * @param $object array объект, который вернул компонент работы с базой
     * @return NotificationUserContentComment
     */
    public static function createModel($object)
    {
        $model = new NotificationUserContentComment;
        foreach ($object as $key => $value)
            $model->$key = $value;

        return $model;
    }
}