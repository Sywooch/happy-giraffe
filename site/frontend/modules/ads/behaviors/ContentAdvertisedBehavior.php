<?php
/**
 * @author Никита
 * @date 05/02/15
 */

namespace site\frontend\modules\ads\behaviors;


class ContentAdvertisedBehavior extends AdvertisedBehavior
{
    public function getCreativeName()
    {
        return $this->owner->title;
    }

    public function getCreativeUrl()
    {
        return $this->owner->url;
    }
}