<?php
/**
 * Class NotificationReplyComment
 *
 * Уведомление пользователю о начале нового конкурса
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class NotificationNewContest extends Notification
{
    public $contest_id;
    public $contest;

    public function setSpecificValues()
    {
        $this->contest = Contest::model()->findByPk($this->contest_id);
    }
}