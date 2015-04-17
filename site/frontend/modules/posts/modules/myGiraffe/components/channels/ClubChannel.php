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
}