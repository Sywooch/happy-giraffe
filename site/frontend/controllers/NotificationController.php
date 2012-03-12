<?php
/**
 * Author: choo
 * Date: 11.03.2012
 */
class NotificationController extends Controller
{
    public function actionGetLast()
    {
        if (Yii::app()->user->isGuest)
            throw CHttpException(403, 'Вы не авторизованы');
        if (Yii::app()->request->isAjaxRequest) {
            $response = UserNotification::model()->getUserData(Yii::app()->user->id);
            echo CJSON::encode($response);
        }
    }
}
