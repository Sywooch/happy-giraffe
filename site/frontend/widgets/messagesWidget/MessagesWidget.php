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
        echo 'хуй';

        $allCount = Im::getContactsCount(Yii::app()->user->id, Im::IM_CONTACTS_ALL);
        $newCount = Im::getContactsCount(Yii::app()->user->id, Im::IM_CONTACTS_NEW);
        $onlineCount = Im::getContactsCount(Yii::app()->user->id, Im::IM_CONTACTS_ONLINE);
        $friendsCount = Im::getContactsCount(Yii::app()->user->id, Im::IM_CONTACTS_FRIENDS);
        $wantToChat = WantToChat::getList(12);
        $hasMessages = Im::hasMessages(Yii::app()->user->id);
        $this->render('index', compact('allCount', 'newCount', 'onlineCount', 'friendsCount', 'wantToChat', 'hasMessages'));
    }
}
