<?php
/**
 * Author: alexk984
 * Date: 01.03.12
 */
class BlogWidget extends UserCoreWidget
{
    public function init()
    {
        parent::init();
        $this->visible = $this->isMyProfile || $this->user->blogPostsCount > 0;
        if ($this->isMyProfile && $this->user->blogPostsCount == 0) $this->viewFile = '_blog_empty';
    }
}