<?php

class UserMoodWidget extends UserCoreWidget
{
    public function init()
    {
        parent::init();
        $this->visible = $this->isMyProfile || $this->user->mood !== null;
    }
}
