<?php

class FamilyWidget extends UserCoreWidget
{
    public function init()
    {
        parent::init();
        $this->visible = $this->isMyProfile || !empty($this->user->partner) || !empty($this->user->babies);
    }
}
