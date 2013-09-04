<?php
/**
 * Class TravellerAward
 *
 * Орден Путешественника
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class TravellerAward extends CCommunityLeader
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $community_id = 21;
        $award_id = ScoreAward::TYPE_TRAVEL;

        self::clubLeader($community_id, $award_id);
    }
}
