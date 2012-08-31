<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 8/30/12
 * Time: 8:44 AM
 * To change this template use File | Settings | File Templates.
 */
class MessagesWidget extends CWidget
{
    public function run()
    {
        $wantToChat = WantToChat::getList(12);
        $this->render('index', compact('wantToChat'));
    }
}
