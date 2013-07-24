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
    const TYPE_INCOMING = 0;
    const TYPE_OUTGOING = 1;

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

    public function actionGet($type)
    {
        $column = ($type == self::TYPE_INCOMING) ? 'to_id' : 'from_id';

        $self = $this;
        $requests = array_map(function($request) use ($type, $self) {
            $user = ($type == $self::TYPE_INCOMING) ? $request->from : $request->to;

            return array(
                'id' => $request->id,
                'user' => array(
                    'id' => $user->id,
                    'online' => (bool) $user->online,
                    'firstName' => $user->first_name,
                    'lastName' => $user->last_name,
                    'ava' => $user->getAva('large'),
                    'age' => ($user->birthday) !== null ? $user->normalizedAge : null,
                    'location' => ($user->address->country_id !== null) ? Yii::app()->controller->renderPartial('/_location', array('data' => $user), true) : null,
                    'family' => (($user->hasPartner() && ! empty($user->partner->name)) || ! empty($user->babies)) ? Yii::app()->controller->renderPartial('/_family', array('data' => $user), true) : null,
                ),
            );
        }, FriendRequest::model()->with('from')->findAllByAttributes(array($column => Yii::app()->user->id, 'status' => 'pending')));

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

    public function actionRestore()
    {
        $requestId = Yii::app()->request->getPost('requestId');

        $success = FriendRequest::model()->updateByPk($requestId, array('status' => 'pending')) > 0;

        $response = compact('success');
        echo CJSON::encode($response);
    }
}
