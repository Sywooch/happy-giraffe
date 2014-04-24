<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 18/04/14
 * Time: 13:55
 * To change this template use File | Settings | File Templates.
 */

class MailMessageNotificationDiscuss extends MailMessage
{
    const COMMENT_LENGTH = 80;

    public $type = 'notificationDiscuss';

    /**
     * @property CommunityContent $model
     */
    public $model;

    /**
     * @property Comment[] $commentsToShow
     */
    public $commentsToShow;

    /**
     * @property int $commentsCount
     */
    public $totalCommentsCount;

    public function getSubject()
    {
        return time();
    }

    public function getMoreCount()
    {
        return $this->totalCommentsCount - count($this->commentsToShow);
    }


}