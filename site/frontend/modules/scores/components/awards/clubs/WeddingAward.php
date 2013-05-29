<?php
/**
 * Class WeddingAward
 *
 * Орден Свадебного гуру
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class WeddingAward extends CCommunityLeader
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $community_id = 32;
        $award_id = ScoreAward::TYPE_WEDDING;

        self::clubLeader($community_id, $award_id);
    }
}
