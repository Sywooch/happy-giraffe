<?php

/**
 * Description of ApiController
 *
 * @author Кирилл
 */
class ApiController extends \site\frontend\components\api\ApiController
{
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
                'actions' => array('relationshipData'),
                'users' => array('?'),
            ),
        );
    }

    public function actionList($userId, $limit = 20)
    {
        if ($limit > 100)
            $limit = 20;

        $friends = Friend::model()->with('friend')->together()->findAllByAttributes(array(
            'user_id' => $userId,
                ), array(
            'select' => 'friend_id',
            'limit' => $limit,
            'order' => 'friend.online DESC, friend.id ASC'
        ));
        
        $this->data = array_map(function($friend) {
            return array('id' => $friend->friend_id);
        }, $friends);
        
        $this->success = true;
    }

    public function actionRelationshipData($userId)
    {
        $isFriend = Friend::model()->areFriends($userId, Yii::app()->user->id);
        $hasIncomingRequest = FriendRequest::model()->findPendingRequest($userId, Yii::app()->user->id) !== null;
        $hasOutgoingRequest = FriendRequest::model()->findPendingRequest(Yii::app()->user->id, $userId) !== null;
        $this->data = compact('isFriend', 'hasIncomingRequest', 'hasOutgoingRequest');
        $this->success = true;
    }
}
