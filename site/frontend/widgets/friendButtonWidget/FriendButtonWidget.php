<?php
/**
 * Author: choo
 * Date: 15.03.2012
 */
class FriendButtonWidget extends CWidget
{
    public $user;

    public function run()
    {
        $this->render('FriendButtonWidget', array(
            'user' => $this->user,
        ));
    }

}
