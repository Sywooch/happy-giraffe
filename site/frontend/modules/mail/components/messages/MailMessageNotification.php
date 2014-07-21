<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 28/04/14
 * Time: 17:04
 */

abstract class MailMessageNotification extends MailMessage
{
    const COMMENT_LENGTH = 9999;
    const COMMENTS_COUNT = 5;

    public function getSubTemplate()
    {
        return $this->type;
    }

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

    public function getTemplateFile()
    {
        return 'notification';
    }
} 