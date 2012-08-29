<?php

class CommentatorDay extends EMongoEmbeddedDocument
{
    const STATUS_FAILED = 0;
    const STATUS_SUCCESS = 1;
    const STATUS_EXCEEDED = 2;

    public $date;
    public $created;
    public $skip_count;

    //stat for closed day
    public $blog_posts = 0;
    public $club_posts = 0;
    public $comments = 0;
    public $status = 0;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'commentator_day';
    }
}
