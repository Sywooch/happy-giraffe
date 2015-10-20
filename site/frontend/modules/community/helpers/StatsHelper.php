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
        $value = self::getCacheComponent()->get($cacheId);
        if ($value === false || $renew) {
            $club = \CommunityClub::model()->findByPk($clubId);
            $label = 'Клуб: ' . $club->title;
            $posts = Content::model()->byLabels(array($label))->findAll();
            $postsIds = array_map(function($post) {
                return $post->originEntityId;
            }, $posts);

            $criteria = new \CDbCriteria();
            $criteria->addInCondition('entity_id', $postsIds);
            $value = Comment::model()->count($criteria);
            self::getCacheComponent()->set($cacheId, $value);
        }
        return $value;
    }

    public static function getRubricCount($rubricId, $renew = false)
    {
        $cacheId = 'StatsHelper.rubricCount.' . $rubricId;
        $value = self::getCacheComponent()->get($cacheId);
        if ($value === false || $renew) {
            $rubric = \CommunityRubric::model()->with('community')->findByPk($rubricId);
            $forum = $rubric->community;
            $posts = Content::model()->byLabels(array('Рубрика: ' . $rubric->title, 'Форум: ' . $forum->title))->findAll();
            $postsIds = array_map(function($post) {
                return $post->originEntityId;
            }, $posts);

            $criteria = new \CDbCriteria();
            $criteria->addInCondition('entity_id', $postsIds);
            $value = Comment::model()->count($criteria);
            self::getCacheComponent()->set($cacheId, $value);
        }
        return $value;
    }

    public static function getByLabels($labels, $renew = false)
    {
        $cacheId = 'StatsHelper.byLabels.' . serialize($labels);
        $value = self::getCacheComponent()->get($cacheId);
        if ($value === false || $renew) {
            $posts = Content::model()->byLabels($labels)->findAll();
            $postsIds = array_map(function($post) {
                return $post->originEntityId;
            }, $posts);

            $criteria = new \CDbCriteria();
            $criteria->addInCondition('entity_id', $postsIds);
            $value = Comment::model()->count($criteria);
            self::getCacheComponent()->set($cacheId, $value);
        }
        return $value;
    }

    public static function warmCache()
    {
        $models = \CommunityClub::model()->findAll();

        echo "Клубы:\n";
        foreach ($models as $m) {
            echo $m->title . "\n";
            self::getSubscribers($m->id, true);
            self::getPosts($m->id, true);
            self::getComments($m->id, true);
            self::getByLabels(array($m->toLabel(), Label::LABEL_NEWS), true);
        }

        $rubrics = \CommunityRubric::model()->findAll('community_id IS NOT NULL AND parent_id IS NULL');
        echo "Рубрики:";
        foreach ($rubrics as $rubric) {
            echo $rubric->title . "\n";
            self::getRubricCount($rubric->id, true);
        }

        self::getByLabels(array(Label::LABEL_NEWS), true);
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