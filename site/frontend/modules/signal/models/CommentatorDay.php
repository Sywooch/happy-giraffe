<?php

/**
 * Выполнение плана за день, сохраняем статистику для пршедших дней, чтобы каждый раз не вычислять ее
 *
 */
class CommentatorDay extends EMongoEmbeddedDocument
{
    const STATUS_FAILED = 0;
    const STATUS_SUCCESS = 1;
    const STATUS_EXCEEDED = 2;

    public $date;
    /**
     * В какое время начал работать
     * @var int
     */
    public $created;
    /**
     * Количество пропусков за день
     * @var int
     */
    public $skip_count;
    /**
     * Количество постов в блог за день
     * @var int
     */
    public $blog_posts = 0;
    /**
     * Количество постов в клуб за день
     * @var int
     */
    public $club_posts = 0;
    /**
     * Количество комментариев, засчитанных за день
     * @var int
     */
    public $comments = 0;
    /**
     * Статус выполнения плана: выполнен, не выполнен, перевыполнен
     * @var int
     */
    public $status = 0;

    /**
     * @param $commentator CommentatorWork
     */
    public function checkStatus($commentator)
    {
        if ($this->blog_posts == $commentator->getBlogPostsLimit() &&
            $this->club_posts == $commentator->getClubPostsLimit() &&
            $this->comments == $commentator->getCommentsLimit()
        )
            $this->status = self::STATUS_SUCCESS;
        elseif ($this->blog_posts >= $commentator->getBlogPostsLimit() &&
            $this->club_posts >= $commentator->getClubPostsLimit() &&
            $this->comments >= $commentator->getCommentsLimit()
        )
            $this->status = self::STATUS_EXCEEDED;
    }

    public function getStatusView()
    {
        if ($this->status == self::STATUS_SUCCESS)
            return '<td class="task-done">Выполнен</td>';
        if ($this->status == self::STATUS_EXCEEDED)
            return '<td class="task-overdone">Перевыполнен</td>';
        return '<td class="task-not-done">Не выполнен</td>';
    }
}
