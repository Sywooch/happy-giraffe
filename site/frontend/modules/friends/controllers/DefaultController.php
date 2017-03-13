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
    public $layout = '//layouts/new/mainLite';
    public function filters()
    {
        return array(
            'accessControl',
            'ajaxOnly - index',
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
        $friendsCount = (int)Friend::model()->getCountByUserId(Yii::app()->user->id);
        $friendsOnlineCount = (int)Friend::model()->getCountByUserId(Yii::app()->user->id, true);
        $friendsNewCount = (int)Friend::model()->getCountByUserId(Yii::app()->user->id, false, true);
        $incomingRequestsCount = (int)FriendRequest::model()->getCountByUserId(Yii::app()->user->id);
        $outgoingRequestsCount = (int)FriendRequest::model()->getCountByUserId(Yii::app()->user->id, false);

        $lists = array_map(function ($list) {
            return array(
                'id' => $list->id,
                'friendsCount' => (int)$list->friendsCount,
                'title' => $list->title,
            );
        }, FriendsManager::getLists(Yii::app()->user->id));

        $data = compact('friendsCount', 'friendsOnlineCount', 'friendsNewCount', 'incomingRequestsCount', 'outgoingRequestsCount', 'lists');

        $this->pageTitle = 'Мои друзья';
        $this->render('index_v2', CJSON::encode($data));
    }

    public function actionGet($online = false, $onlyNew = false, $listId = false, $query = false, $offset = 0)
    {
        $friends = array_map(function ($friend) {
            return array(
                'id' => $friend->id,
                'listId' => $friend->list_id,
                'user' => FriendsManager::userToJson($friend->friend),
                'pCount' => $friend->pCount,
                'bCount' => $friend->bCount,
            );
        }, FriendsManager::getFriends(Yii::app()->user->id, $online, $onlyNew, $listId, $query, $offset));
        $last = FriendsManager::getFriendsCount(Yii::app()->user->id, $online, $onlyNew, $listId, $query, $offset) <= ($offset + FriendsManager::FRIENDS_PER_PAGE);

        $data = compact('friends', 'last');
        echo CJSON::encode($data);
    }

    public function actionDelete()
    {
        $friendId = Yii::app()->request->getPost('friendId');
        $success = Friend::model()->breakFriendship(Yii::app()->user->id, $friendId);

        $response = compact('success');
        echo CJSON::encode($response);
    }

    public function actionRestore()
    {
        $friendId = Yii::app()->request->getPost('friendId');
        $success = Friend::model()->makeFriendship(Yii::app()->user->id, $friendId);

        $response = compact('success');
        echo CJSON::encode($response);
    }

    public function actionRegions($countryId)
    {
        $regions = array_map(function ($region) {
            return array(
                'id' => $region->id,
                'name' => $region->name,
            );
        }, GeoRegion::model()->findAllByAttributes(array('country_id' => $countryId), array('order' => 't.name ASC')));

        echo CJSON::encode($regions);
    }
}
