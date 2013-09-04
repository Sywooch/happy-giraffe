<?php
/**
 * Author: choo
 * Date: 15.03.2012
 */
class FriendButtonWidget extends CWidget
{
    const STATUS_GUEST = 0;
    const STATUS_IS_FRIEND = 1;
    const STATUS_INVITE = 2;
    const STATUS_INVITE_SENT = 3;
    const STATUS_ACCEPT = 4;

    public $user;
    public $view = 'common';

    public function run()
    {
        if ($this->user->id == Yii::app()->user->id)
            return ;

        $status = $this->getStatus();
        $data = array(
            'id' => $this->user->id,
            'status' => $status,
        );
        $this->render($this->view, array(
            'data' => $data,
            'id' => uniqid(),
        ));
    }

    protected function getStatus()
    {
        if (Yii::app()->user->isGuest)
            return self::STATUS_GUEST;

        if (Friend::model()->areFriends(Yii::app()->user->id, $this->user->id))
            return self::STATUS_IS_FRIEND;

        if (FriendRequest::model()->pendingRequestExists(Yii::app()->user->id, $this->user->id))
            return self::STATUS_INVITE_SENT;

        if (FriendRequest::model()->pendingRequestExists($this->user->id, Yii::app()->user->id))
            return self::STATUS_ACCEPT;

        return self::STATUS_INVITE;
    }
}
