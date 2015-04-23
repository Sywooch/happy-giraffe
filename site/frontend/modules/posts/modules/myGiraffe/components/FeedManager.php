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
            self::addRows($rows, $channelIds, $post, $filter);
            foreach ($channelIds as $userId) {
                $allIds[] = $userId;
            }
        }
        $allIds = array_unique($allIds);
        self::addRows($rows, $allIds, $post, 'all');
        if (count($rows) > 0) {
            \Yii::app()->db->getCommandBuilder()->createMultipleInsertCommand(FeedItem::model()->tableName(), $rows)->execute();
        }
    }

    public static function updateForUser($userId)
    {
        \Yii::app()->db->createCommand()->delete(FeedItem::model()->tableName(), 'userId = :userId', array(':userId' => $userId));

        $rows = array();

        $postsAll = array();
        foreach (self::$_filters as $filter => $class) {
            $channel = new $class();
            /** @var \CDbCriteria $criteria */
            $criteria = $channel->getPostsCriteria($userId);
            $criteria->limit = self::LENGTH;
            $criteria->index = 'id';
            $posts = Content::model()->findAll($criteria);
            $postsAll += $posts;
            foreach ($posts as $post) {
                $rows[] = array(
                    'userId' => $userId,
                    'postId' => $post->id,
                    'filter' => $filter,
                    'dtimeCreate' => $post->dtimePublication,
                );
            }
        }

        usort($posts, function($a, $b) {
            return ($a->dtimePublication > $b->dtimePublication) ? 1 : -1;
        });

        $test = array_slice($postsAll, 0, 100);

        foreach ($test as $post) {
            $rows[] = array(
                'userId' => $userId,
                'postId' => $post->id,
                'filter' => 'all',
                'dtimeCreate' => $post->dtimePublication,
            );
        }

        if (count($rows) > 0) {
            \Yii::app()->db->getCommandBuilder()->createMultipleInsertCommand(FeedItem::model()->tableName(), $rows)->execute();
        }
    }

    protected static function addRows(&$array, $userIds, $post, $filter)
    {
        foreach ($userIds as $userId) {
            $array[] = array(
                'userId' => $userId,
                'postId' => $post->id,
                'filter' => $filter,
                'dtimeCreate' => $post->dtimePublication,
            );
        }
    }

//    protected static function createItem($userId, $postId, $filter)
//    {
//        $item = new FeedItem();
//        $item->userId = $userId;
//        $item->postId = $postId;
//        $item->filter = $filter;
//        $item->save();
//
//        \Yii::app()->db->getCommandBuilder()->createMultipleInsertCommand();
//    }
}