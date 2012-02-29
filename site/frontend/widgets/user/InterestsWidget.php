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
        $this->visible = $this->isMyProfile || !empty($this->user->interests);
    }

    public function run()
    {
        if (empty($this->user->interests))
            return;

        $this->render('interests', array(
            'user' => $this->user
        ));
    }
}
