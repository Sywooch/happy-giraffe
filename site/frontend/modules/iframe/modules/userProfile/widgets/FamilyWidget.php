<?php
namespace site\frontend\modules\iframe\modules\userProfile\widgets;

use site\frontend\modules\iframe\modules\userProfile\widgets\UserCoreWidget;

class FamilyWidget extends UserCoreWidget
{
    public function init()
    {
        parent::init();
        $this->visible = !empty($this->user->partner) || !empty($this->user->babies);
    }
}
