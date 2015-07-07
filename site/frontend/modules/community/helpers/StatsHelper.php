<?php
/**
 * @author Никита
 * @date 07/07/15
 */

namespace site\frontend\modules\community\helpers;


use site\frontend\modules\comments\models\Comment;

class StatsHelper
{
    const CACHE_TIME = 10800;
    
    public static function getSubscribers($clubId)
    {
        return \UserClubSubscription::model()->cache(self::CACHE_TIME)->count('club_id = :clubId', array(':clubId' => $clubId));
    }

    public static function getPosts($clubId)
    {
        return \CommunityContent::model()->cache(self::CACHE_TIME)->with('rubric.community')->count('club_id = :clubId', array(':clubId' => $clubId));
    }

    public static function getComments($clubId)
    {
        $criteria = new \CDbCriteria();
        $criteria->join = 'INNER JOIN community__contents cc ON t.entity IN("BlogContent", "CommunityContent") AND cc.id = t.entity_id
            INNER JOIN community__rubrics r ON cc.rubric_id = r.id
            INNER JOIN community__forums f ON f.id = r.community_id';
        $criteria->compare('f.club_id', $clubId);

        return Comment::model()->cache(self::CACHE_TIME)->count($criteria);
    }
}