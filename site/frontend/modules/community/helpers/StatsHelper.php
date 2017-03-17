<?php

/**
 * @author Никита
 * @date 07/07/15
 */

namespace site\frontend\modules\community\helpers;

use site\frontend\modules\comments\models\Comment;
use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;
use site\frontend\modules\posts\models\Tag;

/*
 * у класса не было документации, но в целом он считает колличество комментариев
 * в разделах, подразделах
 * @author crocodile
 */

class StatsHelper
{

    public static function getSubscribers($clubId, $renew = false)
    {
        // Время жизни значения счетчика в кеше, в секундах
        $expire = 240;
        $cacheId = 'StatsHelper.subscribers.' . $clubId;
        $staticCacheId = 'Static.' . $cacheId;

        $value = self::getCacheComponent()->get($cacheId);
        $staticValue = self::getCacheComponent()->get($staticCacheId);

        if ($staticValue === false OR ($value === false and $renew))
        {
            $value = \UserClubSubscription::model()->count('club_id = :clubId', array(':clubId' => $clubId));
            self::getCacheComponent()->set($cacheId, $value, $expire);
            self::getCacheComponent()->set($staticCacheId, $value, 0);
        }

        return $value ?: $staticValue;
    }

    public static function getPosts($clubId, $renew = false)
    {
         // Время жизни значения счетчика в кеше, в секундах
        $expire = 240;
        $cacheId = 'StatsHelper.posts.' . $clubId;
        $staticCacheId = 'Static.' . $cacheId;

        $value = self::getCacheComponent()->get($cacheId);
        $staticValue = self::getCacheComponent()->get($staticCacheId);

        if ($staticValue === false OR ($value === false and $renew))
        {
            $value = \CommunityContent::model()->with('rubric.community')->count('club_id = :clubId', array(':clubId' => $clubId));
            self::getCacheComponent()->set($cacheId, $value, $expire);
            self::getCacheComponent()->set($staticCacheId, $value, 0);
        }

        return $value ?: $staticValue;
    }

    /**
     * получение количества комментариев для раздела
     * @param int $clubId
     * @param bool $renew
     * @return int
     * @author crocodile
     */
    public static function getComments($clubId, $renew = false)
    {
        // Время жизни значения счетчика в кеше, в секундах
        $expire = 240;
        $cacheId = 'StatsHelper.comments.' . $clubId;
        $staticCacheId = 'Static.' . $cacheId;

        $value = self::getCacheComponent()->get($cacheId);
        $staticValue = self::getCacheComponent()->get($staticCacheId);

        if ($staticValue === false OR ($value === false and $renew))
        {
            $club = \CommunityClub::model()->findByPk($clubId);
            $label = 'Клуб: ' . $club->title;
            $value = self::getCommentCount(array($label));

            self::getCacheComponent()->set($cacheId, $value, $expire);
            self::getCacheComponent()->set($staticCacheId, $value, 0);
        }
        return $value ?: $staticValue;
    }

    /**
     * подсчёт колличества комментариев в постах
     * @param array $labelsList
     * @return int
     * @author crocodile
     */
    private static function getCommentCount($labelsList)
    {
        $tags = \site\frontend\modules\posts\models\Label::getIdsByLabels($labelsList);
        $sql = 'SELECT count(*) AS n
FROM post__contents AS pc
JOIN comments AS c FORCE INDEX FOR JOIN(`entity_index`) ON ( c.entity = pc.originEntity and c.entity_id = pc.originEntityId)
WHERE
pc.id IN (SELECT `contentId` FROM `post__tags` WHERE `labelId` IN (' . implode(', ', $tags) . '))
and pc.isRemoved=0
and c.removed=0;';
        $itm = \Yii::app()->db->createCommand($sql)->queryAll(true);
        return $itm[0]['n'];
    }

    public static function getRubricCount($rubricId, $renew = false)
    {
        // Время жизни значения счетчика в кеше, в секундах
        $expire = 240;
        $cacheId = 'StatsHelper.rubricCount.' . $rubricId;
        $staticCacheId = 'Static.' . $cacheId;

        $value = self::getCacheComponent()->get($cacheId);
        $staticValue = self::getCacheComponent()->get($staticCacheId);

        if ($staticValue === false OR ($value === false and $renew))
        {
            $rubric = \CommunityRubric::model()->with('community')->findByPk($rubricId);
            $value = self::getCommentCount(array(
                'Рубрика: ' . $rubric->title,
            ));

            self::getCacheComponent()->set($cacheId, $value, $expire);
            self::getCacheComponent()->set($staticCacheId, $value, 0);
        }
        return $value ?: $staticValue;
    }

    public static function getByLabels($labels, $renew = false)
    {
        $cacheId = 'StatsHelper.byLabels.' . serialize($labels);
        $value = self::getCacheComponent()->get($cacheId);
        if ($value === false || $renew)
        {
            $value = self::getCommentCount($labels);
            self::getCacheComponent()->set($cacheId, $value);
        }
        return $value;
    }

    /**
     * "прогрев кеша коментариев", к сожалению реализовано не как прогрев,
     * а как каждый раз пересчёт значения количества комментариев
     */
    public static function warmCache()
    {
        self::getByLabels(array(Label::LABEL_NEWS), true);
        $models = \CommunityClub::model()->findAll();

        echo "Клубы:\n";
        foreach ($models as $m)
        {
            echo "\t" . $m->title . "\r\n";
            self::getSubscribers($m->id, true);
            self::getPosts($m->id, true);
            self::getComments($m->id, true);
            self::getByLabels(array($m->toLabel(), Label::LABEL_NEWS), true);
        }

        $rubrics = \CommunityRubric::model()->findAll('community_id IS NOT NULL AND parent_id IS NULL');
        echo "Рубрики:";
        foreach ($rubrics as $rubric)
        {
            echo "\t" . $rubric->title . "\r\n";
            self::getRubricCount($rubric->id, true);
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
