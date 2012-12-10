<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/7/12
 * Time: 1:34 PM
 * To change this template use File | Settings | File Templates.
 */
class FrientEventPurpose extends FriendEvent
{
    public $type = FriendEvent::TYPE_PURPOSE_UPDATED;

    public $purpose_id;

    public function createBlock()
    {
        $this->purpose_id = (int) $this->params['model']->id;
        $this->user_id = (int) $this->params['model']->user_id;

        parent::createBlock();
    }
}
