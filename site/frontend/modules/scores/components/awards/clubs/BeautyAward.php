<?php
/**
 * Class BeautyAward
 *
 * Орден Эксперта красоты
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class BeautyAward extends CCommunityLeader
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $community_id = 29;
        $award_id = ScoreAward::TYPE_BEAUTY;

        self::clubLeader($community_id, $award_id);
    }
}
