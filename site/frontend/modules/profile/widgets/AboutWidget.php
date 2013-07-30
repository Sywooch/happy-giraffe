<?php

class AboutWidget extends UserCoreWidget
{
    public function init()
    {
        $this->visible = $this->isMyProfile || !empty($this->user->about);
    }
}
