<?php
/**
 * Author: alexk984
 * Date: 28.09.12
 *
 * Орден Доктора Айболита
 */
class DoctorAward extends CCommunityLeader
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $community_id = array(4, 8, 15, 33);
        $award_id = 22;

        self::clubLeader($community_id, $award_id);
    }
}
