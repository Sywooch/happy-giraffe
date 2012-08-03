<?php
/**
 * Author: alexk984
 * Date: 02.08.12
 */
class NewMessagesWidget extends CWidget
{
    public $user;

    public function run()
    {
        $unread = Im::model($this->user->id)->getUnreadMessagesCount();
        if ($unread > 0){
            $dialogUsers = Im::model($this->user->id)->getUsersWithNewMessages();
            $this->render('new_messages', compact('dialogUsers', 'unread'));
        }
    }
}
