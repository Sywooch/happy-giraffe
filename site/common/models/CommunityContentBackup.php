<?php
/**
 * @author Никита
 * @date 22/07/15
 */

class CommunityContentBackup extends CommunityContent
{
    public function getDbConnection()
    {
        return Yii::app()->dbBackup;
    }
}