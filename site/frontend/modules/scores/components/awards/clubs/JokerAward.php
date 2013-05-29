<?php
/**
 * Author: alexk984
 * Date: 28.09.12
 *
 * Орден "Массовик-затейник"
 */
class JokerAward extends CCommunityLeader
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $community_id = array(19, 20);
        $award_id = 21;

        self::clubLeader($community_id, $award_id);
    }
}
