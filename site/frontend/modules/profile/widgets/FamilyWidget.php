<?php

Yii::import('profile.widgets.UserCoreWidget');

class FamilyWidget extends UserCoreWidget
{
    public function init()
    {
        parent::init();
        $this->visible = !empty($this->user->partner) || !empty($this->user->babies);
    }
}
