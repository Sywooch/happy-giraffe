<?php
/**
 * Author: alexk984
 * Date: 07.03.12
 */
class CometModel extends CComponent
{
    const TYPE_NEW_MESSAGE = 1;
    const TYPE_MESSAGE_READ = 2;
    const TYPE_STATUS_CHANGE = 3;
    const TYPE_USER_WRITE_MESSAGE = 4;

    const TYPE_SIGNAL_UPDATE = 5;
    const TYPE_SIGNAL_DECLINE = 6;
    const TYPE_SIGNAL_TAKEN = 7;
    const TYPE_SIGNAL_EXECUTED = 8;

    public $attributes = array();
    public $type;

    public function Send($user_id){
        $channel_id = MessageCache::GetUserCache($user_id);
        $this->attributes['type'] = $this->type;
        Yii::app()->comet->send($channel_id, $this->attributes);
    }
}
