<?php
/**
 * Author: alexk984
 * Date: 28.09.12
 *
 * Орден Мастера на все  руки
 */
class MasterAward extends CCommunityLeader
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $community_id = array(26);
        $award_id = 7;

        self::clubLeader($community_id, $award_id);
    }
}
