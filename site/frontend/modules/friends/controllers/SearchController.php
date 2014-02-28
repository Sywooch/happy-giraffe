<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 5/6/13
 * Time: 1:10 PM
 * To change this template use File | Settings | File Templates.
 */
class SearchController extends HController
{
    public $layout = '//layouts/new/main';
    
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
        $countries = array_map(function($country) {
            return array(
                'id' => $country->id,
                'name' => $country->name,
            );
        }, GeoCountry::model()->findAll(array('order' => 't.name ASC')));
        $friendsCount = (int)Friend::model()->getCountByUserId(Yii::app()->user->id);
        $friendsOnlineCount = (int)Friend::model()->getCountByUserId(Yii::app()->user->id, true);
        $friendsNewCount = (int)Friend::model()->getCountByUserId(Yii::app()->user->id, false, true);
        $incomingRequestsCount = (int)FriendRequest::model()->getCountByUserId(Yii::app()->user->id);
        $outgoingRequestsCount = (int)FriendRequest::model()->getCountByUserId(Yii::app()->user->id, false);
        $json = compact('countries', 'friendsCount', 'friendsOnlineCount', 'friendsNewCount', 'friendsNewCount', 'incomingRequestsCount', 'outgoingRequestsCount');

        $this->pageTitle = 'Найти друзей';
        $this->render('index_v2', compact('json'));
    }

    public function actionGet()
    {
        $dp = FriendsSearchManager::getDataProvider(Yii::app()->user->id, $_GET);
        $users = array_map(function($user) {
            return array(
                'id' => null,
                'user' => FriendsManager::userToJson($user),
            );
        }, $dp->data);
        $currentPage = $dp->pagination->currentPage + 1;
        $pageCount = $dp->pagination->pageCount;
        $itemCount = $dp->totalItemCount;
        $data = compact('users', 'currentPage', 'pageCount', 'itemCount');
        echo CJSON::encode($data);
    }
}
