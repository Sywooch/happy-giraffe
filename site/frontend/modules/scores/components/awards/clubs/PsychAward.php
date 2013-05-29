<?php
/**
 * Author: alexk984
 * Date: 28.09.12
 *
 * “Семейный психолог”
 */
class PsychAward extends CCommunityLeader
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $community_id = array(32);
        $award_id = 25;

        self::clubLeader($community_id, $award_id);
    }
}
