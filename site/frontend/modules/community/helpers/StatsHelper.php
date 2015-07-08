<?php
/**
 * @author Никита
 * @date 07/07/15
 */

namespace site\frontend\modules\community\helpers;


use site\frontend\modules\comments\models\Comment;

class StatsHelper
{
    public static function getSubscribers($clubId, $renew = false)
    {
        $cacheId = 'StatsHelper.subscribers.' . $clubId;
        $value = self::getCacheComponent()->get($cacheId);
        if ($value === false || $renew) {
            $value = \UserClubSubscription::model()->count('club_id = :clubId', array(':clubId' => $clubId));
            self::getCacheComponent()->set($cacheId, $value);
        }
        return $value;
    }

    public static function getPosts($clubId, $renew = false)
    {
        $cacheId = 'StatsHelper.posts.' . $clubId;
        $value = self::getCacheComponent()->get($cacheId);
        if ($value === false || $renew) {
            $value = \CommunityContent::model()->with('rubric.community')->count('club_id = :clubId', array(':clubId' => $clubId));
            self::getCacheComponent()->set($cacheId, $value);
        }
        return $value;
    }

    public static function getComments($clubId, $renew = false)
    {
        $cacheId = 'StatsHelper.comments.' . $clubId;

        echo $cacheId . "\n";

        $value = self::getCacheComponent()->get($cacheId);
        if ($value === false || $renew) {
            $criteria = new \CDbCriteria();
            $criteria->join = 'INNER JOIN community__contents cc ON t.entity IN("BlogContent", "CommunityContent") AND cc.id = t.entity_id
            INNER JOIN community__rubrics r ON cc.rubric_id = r.id
            INNER JOIN community__forums f ON f.id = r.community_id';
            $criteria->compare('f.club_id', $clubId);
            $value = Comment::model()->count($criteria);
            self::getCacheComponent()->set($cacheId, $value);
        }
        return $value;
    }

    public static function warmCache()
    {
        $models = \CommunityClub::model()->findAll();
        foreach ($models as $m) {
            self::getSubscribers($m->id, true);
            self::getPosts($m->id, true);
            self::getComments($m->id, true);
        }
    }

    /**
     *
     * @return \CCache
     */
    protected static function getCacheComponent()
    {
        return \Yii::app()->getComponent('dbCache');
    }
}