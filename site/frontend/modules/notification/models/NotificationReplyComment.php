<?php
/**
 * Class NotificationReplyComment
 *
 * Уведомление пользователю об ответе на его комментарий
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class NotificationReplyComment extends Notification
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