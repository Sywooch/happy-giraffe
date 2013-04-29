<?php
/**
 * Class NotificationNewComment
 *
 * Уведомление пользователю о новом комментарии
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class NotificationNewComment extends Notification
{
    public $type = self::NEW_COMMENT;
    public $entity;
    public $entity_id;
    public $comment_ids;
    public $comments;

    /**
     * @return NotificationNewComment
     */
    public static function model()
    {
        if (null === self::$_instance)
            self::$_instance = new self();
        return self::$_instance;
    }

    public function setSpecificValues()
    {
        $this->comments = $this->getComments();
    }

    /**
     * @return Comment[]
     */
    public function getComments()
    {
        return Comment::model()->findAllByPk($this->comment_ids);
    }

    /**
     * Создаем уведомление о новом комментарии. Если уведомление к этому посту уже создавалось и еще не было
     * прочитано, то добавляем в него новый комментарий.
     *
     * @param $recipient_id int id пользователя, который должен получить уведомление
     * @param $comment Comment комментарий
     */
    public function create($recipient_id, $comment)
    {
        $exist = $this->getCollection()->findOne(array(
            'type' => self::NEW_COMMENT,
            'recipient_id' => (int)$recipient_id,
            'read' => 0,
            'entity' => $comment->entity,
            'entity_id' => (int)$comment->entity_id,
        ));

        if ($exist)
            $this->update($exist, $comment);
        else
            $this->insert($recipient_id, $comment);
    }

    /**
     * Добавление в существующее уведомление информации о новом комментарии к этой записи/фото
     *
     * @param $exist
     * @param $comment
     */
    private function update($exist, $comment)
    {
        $_id = $exist['_id'];
        unset($exist['_id']);

        $exist['comment_ids'][] = (int)$comment->id;
        $exist['updated'] = time();
        $this->getCollection()->update(
            array('_id' => $_id),
            $exist
        );
    }

    /**
     * Создание нового уведомления о непрочитанном комментарии
     *
     * @param $recipient_id int id пользователя, который должен получить уведомление
     * @param $comment Comment комментарий
     */
    private function insert($recipient_id, $comment)
    {
        self::getCollection()->insert(
            array(
                'type' => self::NEW_COMMENT,
                'recipient_id' => (int)$recipient_id,
                'read' => 0,
                'updated' => time(),
                'entity' => $comment->entity,
                'entity_id' => (int)$comment->entity_id,
                'comment_ids' => array((int)$comment->id)
            )
        );
    }
}