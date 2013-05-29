<?php
/**
 * Class MasterAward
 *
 * Орден Мастера на все руки
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class MasterAward extends CCommunityLeader
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $community_id = 26;
        $award_id = ScoreAward::TYPE_MASTER;

        self::clubLeader($community_id, $award_id);
    }
}
