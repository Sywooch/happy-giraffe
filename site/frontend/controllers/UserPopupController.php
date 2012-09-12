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
            //'ajaxOnly',
        );
    }

    public function actionFriends()
    {
        $requests = Yii::app()->user->model->getFriendRequests('incoming');
        $requests->pagination->pageSize = 999;
        $hasInvitations = $requests->itemCount > 0;
        $findFriends = Yii::app()->user->model->findFriends($hasInvitations ? 4 : 8);

        $this->renderPartial('friends', compact('requests', 'hasInvitations', 'findFriends'), false, true);
    }

    public function actionTest()
    {
        $rUsers = User::model()->findAll(array(
            'order' => 'RAND()',
            'limit' => 20,
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
