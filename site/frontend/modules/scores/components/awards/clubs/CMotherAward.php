<?php
/**
 * Class CMotherAward
 *
 * Орден Почетного Материнства
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class CMotherAward extends CCommunityLeader
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $community_id = range(4, 18);
        $award_id = ScoreAward::TYPE_MOTHER;

        self::clubLeader($community_id, $award_id);
    }
}
