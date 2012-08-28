<?php
/**
 * Хотят общаться
 *
 * Author: choo
 * Date: 15.05.2012
 */
class WantToChatWidget extends CWidget
{
    public $onlyButton = false;

    public function run()
    {
        if ($this->onlyButton) {
            $this->render('_chatButton');
        } else {
            $users = WantToChat::getList(3);
            $this->render('WantToChatWidget', compact('users'));
        }
    }
}
