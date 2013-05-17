<?php
/**
 * Уведомление о том что обсуждение темы продолжается. Отправляется тем кто уже комментировал
 * запись/фото/видео, после того как будет написано еще NEW_COMMENTS_COUNT комментариев.
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */

class NotificationDiscussContinue extends NotificationGroup
{
    /**
     * Количество новых комментариев, после которого показываем уведомление
     * о продолжении дискуссии
     */
    const NEW_COMMENTS_COUNT = 3;
    /**
     * @var NotificationDiscussContinue
     */
    private static $_instance;

    public $type = self::DISCUSS_CONTINUE;

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
     * Найти все непрочитанные уведомления о подписках на продолжение дискуссии
     *
     * @param $entity
     * @param $entity_id
     * @return NotificationDiscussContinue[]
     */
    public function findUnreadDiscussNotifications($entity, $entity_id)
    {
        $cursor = $this->getCollection()->find(array(
            'type' => self::DISCUSS_CONTINUE,
            'entity' => $entity,
            'entity_id' => $entity_id,
            'read' => 0
        ));

        $list = array();
        while ($cursor->hasNext())
            $list[] = $cursor->getNext();

        return $list;
    }

    /**
     * Создаем уведомление о продолжении дискуссии. Есть своя специфика - нужно вычислить
     * все новые комментарии и добавить их в список
     *
     * @param $recipient_id int
     * @param $entity
     * @param $entity_id
     * @param $last_read_comment_id int
     */
    public function create($recipient_id, $entity, $entity_id, $last_read_comment_id)
    {
        $this->recipient_id = (int)$recipient_id;
        $this->entity = $entity;
        $this->entity_id = (int)$entity_id;

        $comment_ids = Comment::getNewCommentIds($entity, $entity_id, $last_read_comment_id);
        foreach ($comment_ids as $key => $comment_id)
            $comment_ids[$key] = (int)$comment_id;

        parent::insert($comment_ids);
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