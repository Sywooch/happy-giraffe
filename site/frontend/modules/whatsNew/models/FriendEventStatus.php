<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/7/12
 * Time: 12:17 PM
 * To change this template use File | Settings | File Templates.
 */
class FriendEventStatus extends FriendEvent
{
    public $type = FriendEvent::TYPE_STATUS_UPDATED;

    public $content_id;

    public function createBlock()
    {
        $this->content_id = (int) $this->params['model']->id;
        $this->user_id = (int) $this->params['model']->author_id;

        parent::createBlock();
    }
}
