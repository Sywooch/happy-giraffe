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
        1 => 'site\frontend\modules\posts\modules\myGiraffe\components\channels\BlogChannel',
        2 => 'site\frontend\modules\posts\modules\myGiraffe\components\channels\ClubChannel',
        3 => 'site\frontend\modules\posts\modules\myGiraffe\components\channels\FriendsChannel',
    );

    public static function handle(Content $post)
    {
        $allIds = array();
        foreach (self::$_filters as $filter => $class) {
            /** @var \site\frontend\modules\posts\modules\myGiraffe\components\channels\BaseChannel $channel */
            $channel = new $class();
            $channelIds = $channel->getUserIds($post);
            foreach ($channelIds as $userId) {
                self::createItem($userId, $post->id, $filter);
            }
            $allIds += $channelIds;
        }

        array_unique($allIds);
        foreach ($allIds as $userId) {
            self::createItem($userId, $post->id, 0);
        }
    }

    protected static function createItem($userId, $postId, $filter)
    {
        $item = new FeedItem();
        $item->userId = $userId;
        $item->postId = $postId;
        $item->filter = $filter;
        $item->save();
    }
}