<?php

namespace site\frontend\modules\posts\behaviors;
use site\frontend\modules\rss\components\RssBehavior;

/**
 * @author Никита
 * @date 05/12/14
 */

class ContentRssBehavior extends RssBehavior
{
    public function getTitle()
    {
        return $this->owner->title;
    }

    public function getDescription()
    {
        return $this->owner->text;
    }

    public function getDate()
    {
        return $this->owner->dtimePublication;
    }

    public function getAuthor()
    {
        return $this->owner->getUser();
    }
} 