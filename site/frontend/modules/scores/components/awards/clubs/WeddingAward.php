<?php
/**
 * Author: alexk984
 * Date: 28.09.12
 *
 * Орден Свадебного гуру
 */
class WeddingAward extends CCommunityLeader
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $community_id = 32;
        $award_id = 6;

        self::clubLeader($community_id, $award_id);
    }
}
