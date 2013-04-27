<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/14/12
 * Time: 12:22 PM
 * To change this template use File | Settings | File Templates.
 */
class FriendsController extends HController
{
    const FRIENDS_PER_PAGE = 14;

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'users' => array('?'),
            ),
        );
    }

    public function actionIndex()
    {
        $friendsCount = Friend::model()->getCountByUserId(Yii::app()->user->id);
        $friendsOnlineCount = Friend::model()->getCountByUserId(Yii::app()->user->id, true);
        $incomingRequestsCount = FriendRequest::model()->getCountByUserId(Yii::app()->user->id);
        $outgoingRequestsCount = FriendRequest::model()->getCountByUserId(Yii::app()->user->id, false);

        $lists = array_map(function($list) {
            return array(
                'id' => $list->id,
                'friendsCount' => (int) $list->friendsCount,
                'title' => $list->title,
            );
        }, FriendsManager::getLists(Yii::app()->user->id));

        $data = compact('friendsCount', 'friendsOnlineCount', 'incomingRequestsCount', 'outgoingRequestsCount', 'lists');
        $this->render('index', CJSON::encode($data));
    }

    public function actionGet($online = false, $listId = false, $offset = 0)
    {
        $_friends = FriendsManager::getFriends(Yii::app()->user->id, self::FRIENDS_PER_PAGE, $online, $listId, $offset);
        $friends = array();
        foreach ($_friends as $friend) {
            $friends[] = array(
                'id' => $friend->friend->id,
                'online' => (bool) $friend->friend->online,
                'firstName' => $friend->friend->first_name,
                'lastName' => $friend->friend->last_name,
                'listId' => $friend->list_id,
            );
        }

        $data = compact('friends');
        echo CJSON::encode($data);
    }

//    public function actionFind($type, $query = null)
//    {
//        if (Yii::app()->request->isAjaxRequest)
//            $this->layout = 'empty';
//
//        $this->pageTitle = 'Поиск друзей на Веселом Жирафе';
//        $dp = FindFriendsManager::getDataProvider($type, $query);
//
//        $this->render('find', compact('dp', 'type'));
//    }
}
