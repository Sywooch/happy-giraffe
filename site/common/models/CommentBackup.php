<?php
/**
 * @author Никита
 * @date 22/07/15
 */

class CommentBackup extends \site\frontend\modules\comments\models\Comment
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