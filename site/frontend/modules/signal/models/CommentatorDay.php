<?php

class CommentatorDay extends EMongoEmbeddedDocument
{
    const STATUS_FAILED = 0;
    const STATUS_SUCCESS = 1;
    const STATUS_EXCEEDED = 2;

    public $date;
    public $created;
    public $skip_count;
    public $today_club = null;

    //stat for closed day
    public $blog_posts = 0;
    public $club_posts = 0;
    public $comments = 0;
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
