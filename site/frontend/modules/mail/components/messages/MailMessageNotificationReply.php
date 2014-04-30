<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 30/04/14
 * Time: 11:50
 */

class MailMessageNotificationReply extends MailMessageNotification
{
    public $type = 'notificationReply';

    /**
     * @var MailComment
     */
    public $comment;
} 