<?php
namespace site\frontend\modules\posts\modules\myGiraffe\components\channels;
use site\frontend\modules\posts\models\Content;

/**
 * @author Никита
 * @date 17/04/15
 */


class FriendsChannel extends BaseChannel
{
    public function getUserIds(Content $post)
    {
        $criteria = new \CDbCriteria();
        $criteria->select = 'id';
        $criteria->compare('user_id', $post->authorId);
        $command = \Yii::app()->db->getCommandBuilder()->createFindCommand(\Friend::model()->tableName(), $criteria);
        return $command->queryColumn();
    }
}