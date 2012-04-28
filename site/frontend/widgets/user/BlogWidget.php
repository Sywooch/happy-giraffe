<?php
/**
 * Author: alexk984
 * Date: 01.03.12
 */
class BlogWidget extends UserCoreWidget
{
    public $count;

    public function init()
    {
        parent::init();
        $this->count = $this->user->blogPostsCount;
        $this->visible = $this->isMyProfile || $this->count > 0;
        if ($this->isMyProfile && $this->count == 0) $this->viewFile = '_blog_empty';
    }
}