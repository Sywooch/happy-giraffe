<?php
/**
 * @author Никита
 * @date 17/04/15
 */

namespace site\frontend\modules\posts\modules\myGiraffe\components\channels;


use site\frontend\modules\posts\models\Content;

class BlogChannel extends BaseChannel
{
    public function getUserIds(Content $post)
    {
        if ($post->originService != 'oldBlog') {
            return array();
        }

        $criteria = new \CDbCriteria();
        $criteria->select = 'user_id';
        $criteria->compare('user2_id', $post->authorId);
        $command = \Yii::app()->db->getCommandBuilder()->createFindCommand(\UserBlogSubscription::model()->tableName(), $criteria);
        return $command->queryColumn();
    }

    public function getPostsCriteria($userId)
    {
        $subscriptions = \UserBlogSubscription::model()->findAll('user_id = :userId', array(':userId' => $userId));
        $authorIds = array_map(function($sub) {
            return $sub->user2_id;
        }, $subscriptions);

        $criteria = new \CDbCriteria();
        $criteria->addInCondition('authorId', $authorIds);
        $criteria->scopes = array('byService' => 'oldBlog');
        return $criteria;
    }
}