<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 16/01/14
 * Time: 16:44
 * To change this template use File | Settings | File Templates.
 */

class UserStatusController extends AntispamController
{
    /**
     * @todo Убрать костыль с refresh
     */
    public function actionListUser()
    {
        $userId = Yii::app()->request->getPost('userId');
        $status = Yii::app()->request->getPost('status');
        $status = AntispamStatusManager::setUserStatus($userId, $status);
        $success = $status !== false;
        $status->refresh();
        echo CJSON::encode(array('success' => $success, 'status' => $status->toJson()));
    }
}