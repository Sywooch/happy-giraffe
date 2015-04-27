<?php
namespace site\frontend\modules\posts\modules\myGiraffe\components;
use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\modules\myGiraffe\models\FeedItem;

/**
 * @author Никита
 * @date 17/04/15
 */

class FeedManager
{
    const LENGTH = 100;

    private static $_filters = array(
        'blog' => 'site\frontend\modules\posts\modules\myGiraffe\components\channels\BlogChannel',
        'club' => 'site\frontend\modules\posts\modules\myGiraffe\components\channels\ClubChannel',
        'friends' => 'site\frontend\modules\posts\modules\myGiraffe\components\channels\FriendsChannel',
    );

    public static function handle(Content $post)
    {
        \Yii::app()->db->createCommand()->delete(FeedItem::model()->tableName(), 'postId = :postId', array(':postId' => $post->id));
        $rows = array();
        $allIds = array();
        foreach (self::$_filters as $filter => $class) {
            /** @var \site\frontend\modules\posts\modules\myGiraffe\components\channels\BaseChannel $channel */
            $channel = new $class();
            $channelIds = $channel->getUserIds($post);
            foreach ($channelIds as $userId) {
                $rows[] = self::getRow($userId, $post, $filter);
                $allIds[] = $userId;
            }
        }
        $allIds = array_unique($allIds);
        foreach ($allIds as $userId) {
            $rows[] = self::getRow($userId, $post, 'all');
        }
        self::save($rows);
    }

    public static function updateForUser($userId)
    {
        \Yii::app()->db->createCommand()->delete(FeedItem::model()->tableName(), 'userId = :userId', array(':userId' => $userId));
        $rows = array();
        $postsAll = array();
        foreach (self::$_filters as $filter => $class) {
            /** @var \site\frontend\modules\posts\modules\myGiraffe\components\channels\BaseChannel $channel */
            $channel = new $class();
            $criteria = $channel->getPostsCriteria($userId);
            $criteria->limit = self::LENGTH;
            $criteria->index = 'id';
            $criteria->scopes[] = 'orderDesc';
            $posts = Content::model()->findAll($criteria);
            $postsAll += $posts;
            foreach ($posts as $post) {
                $rows[] = self::getRow($userId, $post, $filter);
            }
        }
        usort($posts, function($a, $b) {
            return ($a->dtimePublication < $b->dtimePublication) ? 1 : -1;
        });
        $all = array_slice($postsAll, 0, 100);
        foreach ($all as $post) {
            $rows[] = self::getRow($userId, $post, 'all');
        }
        self::save($rows);
    }

    protected static function save($rows)
    {
        if (count($rows) > 0) {
            \Yii::app()->db->getCommandBuilder()->createMultipleInsertCommand(FeedItem::model()->tableName(), $rows)->execute();
        }
    }

    protected static function getRow($userId, $post, $filter)
    {
        return array(
            'userId' => $userId,
            'postId' => $post->id,
            'filter' => $filter,
            'dtimeCreate' => $post->dtimePublication,
        );
    }
}