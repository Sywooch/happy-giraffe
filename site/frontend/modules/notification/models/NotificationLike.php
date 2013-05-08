<?php
/**
 * Class NotificationReplyComment
 *
 * Уведомление пользователю о лайке его контента
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class NotificationLike extends NotificationGroup
{
    /**
     * @var Notification
     */
    private static $_instance;
    public $type = self::NEW_LIKE;

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
     * @return User[]
     */
    public function getUsers()
    {
        return User::model()->findAllByPk($this->model_ids);
    }

    /**
     * Создаем уведомление о новом комментарии. Если уведомление к этому посту уже создавалось и еще не было
     * прочитано, то добавляем в него новый комментарий и увеличиваем кол-во нотификаций
     *
     * @param $recipient_id int id пользователя, который должен получить уведомление
     * @param $like RatingYohoho лайк
     */
    public function create($recipient_id, $like)
    {
        $this->recipient_id = (int)$recipient_id;
        $this->entity = $like->entity_name;
        $this->entity_id = $like->entity_id;

        parent::create($like->user_id);
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
     * @return NotificationNewComment
     */
    public static function createModel($object)
    {
        $model = new NotificationLike();
        foreach($object as $key => $value)
            $model->$key = $value;

        return $model;
    }
}