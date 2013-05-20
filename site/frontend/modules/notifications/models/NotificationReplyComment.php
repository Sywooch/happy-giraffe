<?php
/**
 * Class NotificationReplyComment
 *
 * Уведомление пользователю об ответе на его комментарий
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class NotificationReplyComment extends NotificationGroup
{
    /**
     * @var NotificationReplyComment
     */
    private static $_instance;
    public $type = self::REPLY_COMMENT;
    /**
     * @var int id комментария пользователя на который он получает ответы
     */
    public $comment_id;

    public function __construct()
    {
    }

    /**
     * @return NotificationReplyComment
     */
    public static function model()
    {
        if (null === self::$_instance)
            self::$_instance = new self();
        return self::$_instance;
    }

    /**
     * Создаем уведомление об ответе на его комментарий. Если уведомление к этому комментарию уже создавалось
     * и еще не было прочитано, то добавляем в него новый комментарий и увеличиваем кол-во нотификаций
     *
     * @param $comment Comment комментарий
     * @param $response Comment комментарий на который ответили
     */
    public function create($comment, $response)
    {
        $this->recipient_id = (int)$response->author_id;
        $this->entity = $comment->entity;
        $this->entity_id = (int)$comment->entity_id;

        parent::create($comment->id, array('comment_id' => (int)$response->id));
    }

    /**
     * Создает модель уведомления для удобой работы с ним
     *
     * @param $object array объект, который вернул компонент работы с базой
     * @return NotificationReplyComment
     */
    public static function createModel($object)
    {
        $model = new NotificationReplyComment;
        foreach ($object as $key => $value)
            $model->$key = $value;

        return $model;
    }
}