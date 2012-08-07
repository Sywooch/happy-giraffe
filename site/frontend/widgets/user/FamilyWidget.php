<?php
/**
 * Author: alexk984
 * Date: 01.03.12
 */
class FamilyWidget extends UserCoreWidget
{
    public $showEmpty = false;
    public function init()
    {
        parent::init();
        $this->visible = ($this->user->babyCount() > 0)
            || ($this->user->hasPartner() && !empty($this->user->partner->name))
            || $this->isMyProfile;
    }
}