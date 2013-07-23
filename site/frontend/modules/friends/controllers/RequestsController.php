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
    public function filters()
    {
        return array(
            'accessControl',
            'ajaxOnly',
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
        $fromId = Yii::app()->request->getPost('fromId');
        $requestId = Yii::app()->request->getPost('requestId');

        if ($requestId === null)
            $request = FriendRequest::model()->findPendingRequest($fromId, Yii::app()->user->id);
        else
            $request = FriendRequest::model()->findByPk($requestId);

        $success = Friend::model()->makeFriendship($request->from_id, $request->to_id) && FriendRequest::model()->updateByPk($request->id, array('status' => 'accepted')) > 0;

        $response = compact('success');
        echo CJSON::encode($response);
    }

    public function actionDecline()
    {
        $fromId = Yii::app()->request->getPost('fromId');
        $requestId = Yii::app()->request->getPost('requestId');

        if ($requestId === null)
            $requestId = FriendRequest::model()->findPendingRequest($fromId, Yii::app()->user->id)->id;

        $success = FriendRequest::model()->updateByPk($requestId, array('status' => 'declined')) > 0;

        $response = compact('success');
        echo CJSON::encode($response);
    }

    public function actionCancel() {
        $toId = Yii::app()->request->getPost('toId');
        $requestId = Yii::app()->request->getPost('requestId');

        if ($requestId === null)
            $requestId = FriendRequest::model()->findPendingRequest(Yii::app()->user->id, $toId)->id;

        $success = FriendRequest::model()->deleteByPk($requestId) > 0;

        $response = compact('success');
        echo CJSON::encode($response);
    }
}
