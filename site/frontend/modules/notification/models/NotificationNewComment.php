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
    public $comment_id;
    public $comment;

    public function setSpecificValues()
    {
        $this->comment = $this->getComment();
    }

    public function getComment()
    {
        return Comment::model()->findByPk($this->comment_id);
    }
}