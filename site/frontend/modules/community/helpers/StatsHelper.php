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
        $cacheId = 'StatsHelper.subscribers.' . $clubId;
        $value = self::getCacheComponent()->get($cacheId);
        if ($value === false || $renew)
        {
            $value = \UserClubSubscription::model()->count('club_id = :clubId', array(':clubId' => $clubId));
            self::getCacheComponent()->set($cacheId, $value);
        }
        return $value;
    }

    public static function getPosts($clubId, $renew = false)
    {
        $cacheId = 'StatsHelper.posts.' . $clubId;
        $value = self::getCacheComponent()->get($cacheId);
        if ($value === false || $renew)
        {
            $value = \CommunityContent::model()->with('rubric.community')->count('club_id = :clubId', array(':clubId' => $clubId));
            self::getCacheComponent()->set($cacheId, $value);
        }
        return $value;
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
        $cacheId = 'StatsHelper.comments.' . $clubId;
        $value = self::getCacheComponent()->get($cacheId);
        if ($value === false || $renew)
        {
            $club = \CommunityClub::model()->findByPk($clubId);
            $label = 'Клуб: ' . $club->title;
            $value = self::getCommentCount(array($label));

            self::getCacheComponent()->set($cacheId, $value);
        }
        return $value;
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
        $sql = 'SELECT count(pc.`id`) AS n
FROM post__contents AS pc
JOIN post__tags AS t ON (pc.id=t.contentId)
JOIN comments AS c ON ( c.entity = pc.originEntity and c.entity_id = pc.originEntityId)
WHERE
    t.labelId in(' . implode(', ', $tags) . ') and
     pc.isRemoved=0 and
     c.removed=0 ';
        $itm = \Yii::app()->db->createCommand($sql)->queryAll(true);
        return $itm[0]['n'];
    }

    public static function getRubricCount($rubricId, $renew = false)
    {
        $cacheId = 'StatsHelper.rubricCount.' . $rubricId;
        $value = self::getCacheComponent()->get($cacheId);
        if ($value === false || $renew)
        {
            $rubric = \CommunityRubric::model()->with('community')->findByPk($rubricId);
            //$forum = $rubric->community;
            $value = self::getCommentCount(array(
                'Рубрика: ' . $rubric->title,
                //'Форум: ' . $forum->title
            ));
//            $rubric = \CommunityRubric::model()->with('community')->findByPk($rubricId);
//            $forum = $rubric->community;
//            $posts = Content::model()->byLabels(array('Рубрика: ' . $rubric->title, 'Форум: ' . $forum->title))->findAll();
//            $postsIds = array_map(function($post)
//            {
//                return $post->originEntityId;
//            }, $posts);
//
//            $criteria = new \CDbCriteria();
//            $criteria->addInCondition('entity_id', $postsIds);
//            $value = Comment::model()->count($criteria);
            self::getCacheComponent()->set($cacheId, $value);
        }
        return $value;
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
     * Счетчик специально для новостных тем
     * @param $labels
     * @param bool $renew
     * @return mixed
     */
    public static function countCommentNewsTopicByLabels($labels, $renew = false)
    {
        $cacheId = 'StatsHelper.byLabels.' . serialize($labels);
        $value = self::getCacheComponent()->get($cacheId);
        if ($value === false || $renew)
        {
            $value = self::counterForNewsTopic($labels);
            self::getCacheComponent()->set($cacheId, $value);
        }
        return $value;
    }

    private static function counterForNewsTopic($labelsList)
    {
        $tags = \site\frontend\modules\posts\models\Label::getIdsByLabels($labelsList);
        $sql = 'SELECT COUNT(pc.id) as n
FROM post__contents AS pc
JOIN comments AS c ON ( c.entity = pc.originEntity and c.entity_id = pc.originEntityId)
WHERE
     pc.id IN (SELECT `contentId`
                FROM `post__tags`
                WHERE `labelId` IN (' . implode(', ', $tags) . ')
                GROUP BY `contentId`
                HAVING COUNT(`labelId`) = '.count($tags).') and
     pc.isRemoved=0 and
     c.removed=0';
        $itm = \Yii::app()->db->createCommand($sql)->queryAll(true);
        return $itm[0]['n'];
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
