<?php
/**
 * Author: alexk984
 * Date: 28.09.12
 *
 * Орден Путешественника
 */
class TravellerAward extends CCommunityLeader
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $community_id = 21;
        $award_id = 3;

        self::clubLeader($community_id, $award_id);
    }
}
