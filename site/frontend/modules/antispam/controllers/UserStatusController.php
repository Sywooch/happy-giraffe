<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 16/01/14
 * Time: 16:44
 * To change this template use File | Settings | File Templates.
 */

class UserStatusController extends HController
{
    public function actionListUser()
    {
        $userId = Yii::app()->request->getPost('userId');
        $newStatus = Yii::app()->request->getPost('newStatus');
        AntispamStatusManager::setUserStatus($userId, $newStatus);
    }
}