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
    private static $_filters = array(
        'blog' => 'site\frontend\modules\posts\modules\myGiraffe\components\channels\BlogChannel',
        'club' => 'site\frontend\modules\posts\modules\myGiraffe\components\channels\ClubChannel',
        'friends' => 'site\frontend\modules\posts\modules\myGiraffe\components\channels\FriendsChannel',
    );

    public static function handle(Content $post)
    {
        $rows = array();

        $allIds = array();
        foreach (self::$_filters as $filter => $class) {
            /** @var \site\frontend\modules\posts\modules\myGiraffe\components\channels\BaseChannel $channel */
            $channel = new $class();
            $channelIds = $channel->getUserIds($post);
            foreach ($channelIds as $userId) {
                $rows[] = array(
                    'userId' => $userId,
                    'postId' => $post->id,
                    'filter' => $filter,
                );
                $allIds[] = $userId;
            }
        }
        array_unique($allIds);
        foreach ($allIds as $userId) {
            $rows[] = array(
                'userId' => $userId,
                'postId' => $post->id,
                'filter' => 'all',
            );
        }

        echo count($rows);

        //\Yii::app()->db->getCommandBuilder()->createMultipleInsertCommand(FeedItem::model()->tableName(), $rows);
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