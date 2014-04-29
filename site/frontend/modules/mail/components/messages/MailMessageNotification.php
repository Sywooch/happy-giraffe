<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 28/04/14
 * Time: 17:04
 */

class MailMessageNotification extends MailMessage
{
    const COMMENT_LENGTH = 80;

    /**
     * @property HActiveRecord $model
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