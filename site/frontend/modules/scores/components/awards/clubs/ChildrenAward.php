<?php
/**
 * Author: alexk984
 * Date: 28.09.12
 *
 * Орден Почетного Материнства
 */
class ChildrenAward extends CCommunityLeader
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $community_id = range(1, 18);
        $award_id = 26;

        self::clubLeader($community_id, $award_id);
    }
}
