<?php
/**
 * @author Никита
 * @date 22/07/15
 */

class CommunityContentBackup extends CommunityContent
{
    public function getDbConnection()
    {
        die('123');

        if(self::$db!==null)
            return self::$db;
        else
        {
            self::$db=Yii::app()->getComponent('dbBackup');
            if(self::$db instanceof CDbConnection)
                return self::$db;
            else
                throw new CDbException(Yii::t('yii','Active Record requires a "db" CDbConnection application component.'));
        }
    }
}