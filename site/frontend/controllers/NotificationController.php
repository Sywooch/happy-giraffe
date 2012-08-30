<?php
/**
 * Author: choo
 * Date: 11.03.2012
 */
class NotificationController extends HController
{
    public function filters()
    {
        return array(
            //'ajaxOnly',
        );
    }

    public function actionGetLast()
    {
        $notifications = UserNotification::model()->getUserData(Yii::app()->user->id);
        $friends = UserFriendNotification::model()->getUserData(Yii::app()->user->id);
        $im = Im::model()->getNotificationMessages();
        $response = array(
            'notifications' => $notifications,
            'friends' => $friends,
            'im' => $im
        );
        echo CJSON::encode($response);
    }

    public function actionDelete()
    {
        $id = Yii::app()->request->getPost('id');
        $model = UserFriendNotification::model()->findByPk(new MongoID($id));
        echo $model->delete();
    }
}
