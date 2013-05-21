<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 9/12/12
 * Time: 9:54 AM
 * To change this template use File | Settings | File Templates.
 */
class UserPopupController extends HController
{
    public function filters()
    {
        return array(
            'ajaxOnly',
        );
    }

    public function actionNotifications()
    {
        $dp = UserNotification::model()->getUserNotifications(Yii::app()->user->id);

        $this->renderPartial('notifications', compact('dp'), false, true);
    }

    public function actionFriends($ajax = false)
    {
        $requests = Yii::app()->user->model->getFriendRequests('incoming');
        $requests->pagination->pageSize = 999;
        $hasInvitations = $requests->itemCount > 0;

        $findFriends = Yii::app()->user->model->findFriends($hasInvitations ? 4 : 8);

        $friendsCount = Yii::app()->user->model->getFriendsCount();

        $lastFriendCriteria = Yii::app()->user->model->getFriendsCriteria(array(
            'select' => 't.*, friends.created AS fCreated',
            'order' => 'friends.created DESC',
        ));

        $lastFriend = User::model()->find($lastFriendCriteria);

//        $newsCriteria = UserAction::model()->getFriendsCriteria(Yii::app()->user->id);
//        $newsCriteria->limit(10);
//        $newsCriteria->setSort(array('updated', EMongoCriteria::SORT_DESC));
//        $news = UserAction::model()->findAll($newsCriteria);
        $news =array();

        $this->renderPartial('friends', compact('requests', 'friendsCount', 'lastFriend', 'hasInvitations', 'findFriends', 'news', 'ajax'), false, true);
    }

    public function actionTest()
    {
        $rUsers = User::model()->findAll(array(
            'order' => 'RAND()',
            'limit' => 3,
            'condition' => 'id != 12936',
        ));

        foreach ($rUsers as $u) {
            $r = new FriendRequest;
            $r->from_id = $u->id;
            $r->to_id = 12936;
            $r->save();
        }
    }
}
