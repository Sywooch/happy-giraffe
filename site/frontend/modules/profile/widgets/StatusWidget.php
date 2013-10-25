<?php

class StatusWidget extends UserCoreWidget
{
    public $last_status;
    public function init()
    {
        parent::init();
        $this->last_status = $this->user->getLastStatus();
        $this->visible = !empty($this->last_status);
    }
}
