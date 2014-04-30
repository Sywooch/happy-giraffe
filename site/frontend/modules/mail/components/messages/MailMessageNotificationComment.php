<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 29/04/14
 * Time: 14:51
 */

class MailMessageNotificationComment extends MailMessageNotification
{
    public $type = 'notificationComment';

    public function getSubTemplate()
    {
        if ($this->model instanceof AlbumPhoto) {
            return 'notificationCommentPhoto';
        } elseif ($this->model instanceof CommunityContent && $this->model->type_id == CommunityContent::TYPE_QUESTION) {
            return 'notificationCommentQuestion';
        } else {
            return 'notificationCommentPost';
        }
    }
} 