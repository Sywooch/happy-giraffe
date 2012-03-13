<?php
/**
 * Author: choo
 * Date: 11.03.2012
 */
class NotificationController extends Controller
{
    public function actionGetLast()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $notifications = UserNotification::model()->getUserData(Yii::app()->user->id);
            $friends = UserFriendNotification::model()->getUserData(Yii::app()->user->id);
            $response = array(
                'notifications' => $notifications,
                'friends' => $friends,
            );
            echo CJSON::encode($response);
        }
    }
}
