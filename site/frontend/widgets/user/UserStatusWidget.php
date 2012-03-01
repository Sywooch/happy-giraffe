<?php

class UserStatusWidget extends UserCoreWidget
{
    public function init()
    {
        parent::init();
        $this->visible = $this->isMyProfile || $this->user->status !== null;
    }
}
