<?php
/**
 * Class FashionAward
 *
 * Орден Коко Шанель
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class FashionAward extends CCommunityLeader
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $community_id = 30;
        $award_id = ScoreAward::TYPE_FASHION;

        self::clubLeader($community_id, $award_id);
    }
}
