<?php
/**
 * Class JokerAward
 *
 * Орден "Массовик-затейник"
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class JokerAward extends CCommunityLeader
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $community_id = array(19, 20);
        $award_id = ScoreAward::TYPE_JOKER;

        self::clubLeader($community_id, $award_id);
    }
}
