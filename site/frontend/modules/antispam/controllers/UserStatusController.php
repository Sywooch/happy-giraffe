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
    public function actionToWhiteList()
    {
        $this->changeStatus(AntispamStatusManager::STATUS_WHITE);
    }

    public function actionToBlackList()
    {
        $this->changeStatus(AntispamStatusManager::STATUS_BLACK);
    }

    public function actionToBlockedList()
    {
        $this->changeStatus(AntispamStatusManager::STATUS_BLOCKED);
    }

    public function actionToGrayList()
    {
        $this->changeStatus(AntispamStatusManager::STATUS_BLOCKED);
    }

    protected function chageUserStatus($newStatus)
    {
        $userId = Yii::app()->request->getPost('userId');
        AntispamStatusManager::setUserStatus($userId, $newStatus);
    }
}