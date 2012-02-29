<?php

class UserPurposeWidget extends UserCoreWidget
{
    public function init()
    {
        parent::init();
        $this->visible = $this->isMyProfile || $this->user->purpose !== null;
    }
}
