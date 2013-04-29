<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/14/12
 * Time: 12:22 PM
 * To change this template use File | Settings | File Templates.
 */
class DefaultController extends HController
{
    const FRIENDS_PER_PAGE = 14;

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

    public function actionSearch()
    {
        $dp = FriendsSearchManager::search(15385, $_GET);

        $this->render('search', compact('dp'));
    }

    public function actionGet($online = false, $listId = false, $query = false, $offset = 0)
    {
        $friends = array_map(function($friend) {
            return array(
                'id' => $friend->id,
                'listId' => $friend->list_id,
                'user' => array(
                    'id' => $friend->friend->id,
                    'online' => (bool) $friend->friend->online,
                    'firstName' => $friend->friend->first_name,
                    'lastName' => $friend->friend->last_name,
                ),
            );
        }, FriendsManager::getFriends(Yii::app()->user->id, self::FRIENDS_PER_PAGE, $online, $listId, $query, $offset));

        $data = compact('friends');
        echo CJSON::encode($data);
    }

    public function actionDelete()
    {
        $friendId = Yii::app()->request->getPost('friendId');
        $success = Friend::model()->deleteByPk($friendId) > 0;

        $response = compact('success');
        echo CJSON::encode($response);
    }
}
