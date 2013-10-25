<?php
/**
 * Class FlowersAward
 *
 * Экофан
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class FlowersAward extends CCommunityLeader
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $community_id = 35;
        $award_id = ScoreAward::TYPE_FLOWERS;

        self::clubLeader($community_id, $award_id);
    }
}
