<?php

namespace site\frontend\modules\rss\behaviors;
use site\frontend\modules\rss\components\RssBehavior;


/**
 * @author Никита
 * @date 05/12/14
 */

class ContentRssBehavior extends RssBehavior
{
    public function getRssTitle()
    {
        return $this->owner->title;
    }

    public function getRssDescription()
    {
        return $this->owner->text;
    }

    public function getRssDate()
    {
        return $this->owner->dtimePublication;
    }

    public function getRssAuthor()
    {
        return $this->owner->getUser();
    }

    public function getRssUrl()
    {
        return $this->owner->url;
    }
} 