<?php

/**
 * Description of ApiController
 *
 * @author Кирилл
 */
class ApiController extends \site\frontend\components\api\ApiController
{

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

        $this->data['list'] = array_map(function($friend) {
            return array('id' => $friend->friend_id);
        }, $friends);

        $this->data['total'] = (int) Friend::model()->countByAttributes(array('user_id' => $userId));

        $this->success = true;
    }

}
