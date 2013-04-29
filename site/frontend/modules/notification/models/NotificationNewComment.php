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
    public $comment;

    public function setSpecificValues()
    {
        $this->comment = $this->getComment();
    }

    /**
     * @return Comment[]
     */
    public function getComments()
    {
        return Comment::model()->findAllByPk($this->comment_ids);
    }

    /**
     * @param $recipient_id int id пользователя, который должен получить уведомление
     * @param $comment Comment комментарий
     */
    public function create($recipient_id, $comment)
    {
        $exist = $this->getCollection()->findOne(array(
            'type' => self::NEW_COMMENT,
            'recipient_id' => (int)$recipient_id,
            'entity' => $comment->entity,
            'entity_id' => (int)$comment->entity_id,
        ));

        if (!empty($exist)){

        }
    }
}