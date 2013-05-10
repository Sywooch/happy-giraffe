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
     * @var NotificationUserContentComment
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
     * @return Comment[]
     */
    public function getComments()
    {
        return Comment::model()->findAllByPk($this->model_ids);
    }

    /**
     * Создаем уведомление о новом комментарии. Если уведомление к этому посту уже создавалось и еще не было
     * прочитано, то добавляем в него новый комментарий и увеличиваем кол-во нотификаций
     *
     * @param $comment Comment комментарий
     */
    public function create($comment)
    {
        $this->recipient_id = (int)$comment->author_id;
        $this->entity = $comment->entity;
        $this->entity_id = (int)$comment->entity_id;

        parent::create($comment->id);
    }

    /**
     * Помечаем что уведомление о новых комментариях к статье прочитано
     *
     * @param $recipient_id int id пользователя, который должен получить уведомление
     * @param $entity string класс модели, к которой написан комментарий
     * @param $entity_id int id модели, к которой написан комментарий
     */
    public function read($recipient_id, $entity, $entity_id){
        parent::read($recipient_id, $entity, $entity_id);
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
        foreach($object as $key => $value)
            $model->$key = $value;

        return $model;
    }
}