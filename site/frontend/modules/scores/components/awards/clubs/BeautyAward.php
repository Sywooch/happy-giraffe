<?php
/**
 * Author: alexk984
 * Date: 28.09.12
 *
 * Орден Эксперта красоты
 */
class BeautyAward extends CCommunityPostsLeader
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $community_id = 29;
        $award_id = 8;

        self::clubLeader($community_id, $award_id);
    }
}
