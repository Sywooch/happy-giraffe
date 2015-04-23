<?php
/**
 * @author Никита
 * @date 17/04/15
 */

namespace site\frontend\modules\posts\modules\myGiraffe\components\channels;


use site\frontend\modules\posts\models\Content;

class ClubChannel extends BaseChannel
{
    public function getUserIds(Content $post)
    {
        if ($post->originService != 'oldCommunity') {
            return array();
        }

        $clubId = \CommunityContent::model()->findByPk($post->originEntityId)->rubric->community->club_id;

        $criteria = new \CDbCriteria();
        $criteria->select = 'user_id';
        $criteria->compare('club_id', $clubId);
        $command = \Yii::app()->db->getCommandBuilder()->createFindCommand(\UserClubSubscription::model()->tableName(), $criteria);
        return $command->queryColumn();
    }


    public function getPostsCriteria($userId)
    {
        $subscriptions = \UserClubSubscription::model()->findAll('user_id = :userId', array(':userId' => $userId));
        $clubIds = array_map(function($sub) {
            return $sub->club_id;
        }, $subscriptions);

        $criteria = new \CDbCriteria();
        $criteria->with = array(
            'rubric' => array(
                'with' => 'community',
            ),
        );
        $criteria->addInCondition('club_id', $clubIds);
        $contents = \CommunityContent::model()->findAll($criteria);

        $criteria2 = new \CDbCriteria();
        $criteria2->addInCondition('originEntityId', array_map(function($content) {
            return $content->id;
        }, $contents));
        $criteria2->scopes = array('byService' => 'oldCommunity');

        return $criteria2;
    }
}