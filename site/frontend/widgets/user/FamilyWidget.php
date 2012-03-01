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
        $this->visible = $this->isMyProfile || (count($this->user->babies) > 0) || (
            User::relationshipStatusHasPartner($this->user->relationship_status) && isset($this->user->partner));
    }
}