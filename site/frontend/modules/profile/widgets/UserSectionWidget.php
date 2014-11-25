<?php
/**
 * @author Никита
 * @date 28/10/14
 */

class UserSectionWidget extends CWidget
{
    public $user;

    public function run()
    {
        $this->render('UserSectionWidget', array('user' => $this->user));
    }
} 