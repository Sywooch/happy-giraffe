<?php
/**
 * Author: alexk984
 * Date: 01.03.12
 */
class FamilyWidget extends UserCoreWidget
{
    public function init()
    {
        parent::init();
        $this->visible = ((count($this->user->realBabies) > 0) || (
        User::relationshipStatusHasPartner($this->user->relationship_status)
            && !empty($this->user->partner->name))) || $this->isMyProfile;
    }
}