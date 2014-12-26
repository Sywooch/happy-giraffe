<?php
/**
 * @author Никита
 * @date 08/12/14
 */

namespace site\frontend\modules\rss\behaviors;


use site\frontend\modules\rss\components\RssBehavior;

class CommentRssBehavior extends RssBehavior
{
    public function getRssTitle()
    {
        $commentEntity = $this->owner->getCommentEntity();
        return 'Комментарий к записи ' . $commentEntity->title;
    }

    public function getRssDescription()
    {
        return $this->owner->text;
    }

    public function getRssDate()
    {
        return $this->owner->created;
    }

    public function getRssAuthor()
    {
        return $this->owner->author;
    }

    public function getRssUrl()
    {
        return $this->owner->getUrl(true);
    }
} 