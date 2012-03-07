<?php
/**
 * Author: alexk984
 * Date: 29.02.12
 */
class InterestsWidget extends UserCoreWidget
{
    public function init()
    {
        parent::init();
        $this->visible = !empty($this->user->interests);
    }
}
