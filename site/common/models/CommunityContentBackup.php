<?php
/**
 * @author Никита
 * @date 22/07/15
 */

class CommunityContentBackup extends CommunityContent
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getDbConnection()
    {
        return Yii::app()->dbBackup;
    }
}