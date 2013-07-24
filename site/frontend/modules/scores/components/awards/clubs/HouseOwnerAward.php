<?php
/**
 * Class HouseOwnerAward
 *
 * Орден Домовладельца
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class HouseOwnerAward extends CCommunityLeader
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $community_id = 34;
        $award_id = ScoreAward::TYPE_HOMEOWNER;

        self::clubLeader($community_id, $award_id);
    }
}
