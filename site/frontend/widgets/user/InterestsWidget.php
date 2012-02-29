<?php
/**
 * Author: alexk984
 * Date: 29.02.12
 */
class InterestsWidget extends UserCoreWidget
{
    public function run()
    {
        if (empty($this->user->interests))
            return;

        $this->render('interests', array(
            'user' => $this->user
        ));
    }
}
