<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 4/28/13
 * Time: 3:26 PM
 * To change this template use File | Settings | File Templates.
 */
class RequestsController extends HController
{
    public function actionGet()
    {
        $requests = array_map(function($request) {
            return array(
                'id' => $request->id,
                'user' => array(
                    'id' => $request->from->id,
                    'online' => (bool) $request->from->online,
                    'firstName' => $request->from->first_name,
                    'lastName' => $request->from->last_name,
                    'ava' => $request->from->getAva('large'),
                ),
            );
        }, FriendRequest::model()->with('from')->findAllByAttributes(array('to_id' => Yii::app()->user->id, 'status' => 'pending')));

        $response = compact('requests');
        echo CJSON::encode($response);
    }

    public function actionAccept()
    {
        $requestId = Yii::app()->request->getPost('requestId');

        $request = FriendRequest::model()->findByPk($requestId);
        $success = Friend::model()->makeFriendship($request->from_id, $request->to_id) && FriendRequest::model()->updateByPk($requestId, array('status' => 'accepted')) > 0;

        $response = compact('success');
        echo CJSON::encode($response);
    }

    public function actionDecline()
    {
        $requestId = Yii::app()->request->getPost('requestId');

        $success = FriendRequest::model()->updateByPk($requestId, array('status' => 'declined')) > 0;

        $response = compact('success');
        echo CJSON::encode($response);
    }
}
