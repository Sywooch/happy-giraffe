<?php
namespace site\frontend\modules\posts\modules\myGiraffe\components\channels;
use site\frontend\modules\posts\models\Content;

/**
 * @author Никита
 * @date 17/04/15
 */

\Yii::import('site.frontend.modules.friends.models.*');

class FriendsChannel extends BaseChannel
{
    public function getUserIds(Content $post)
    {
        return $this->getFriends($post->authorId);
    }

    public function getPostsCriteria($userId)
    {
        $friends = $this->getFriends($userId);
        $criteria = new \CDbCriteria();
        $criteria->addInCondition('authorId', $friends);
        $criteria->scopes = array('byService' => 'oldBlog');
        return $criteria;
    }

    protected function getFriends($userId)
    {
        $criteria = new \CDbCriteria();
        $criteria->select = 'id';
        $criteria->compare('user_id', $userId);
        $command = \Yii::app()->db->getCommandBuilder()->createFindCommand(\Friend::model()->tableName(), $criteria);
        return $command->queryColumn();
    }
}