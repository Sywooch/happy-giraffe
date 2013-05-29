<?php
/**
 * Author: alexk984
 * Date: 28.09.12
 *
 * Экофан
 */
class FlowersAward extends CCommunityLeader
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $community_id = 35;
        $award_id = 29;

        self::clubLeader($community_id, $award_id);
    }
}
