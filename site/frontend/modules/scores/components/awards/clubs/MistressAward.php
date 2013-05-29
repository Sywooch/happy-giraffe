<?php
/**
 * Author: alexk984
 * Date: 28.09.12
 *
 * Орден Мастерицы
 */
class MistressAward extends CCommunityLeader
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $community_id = array(24,25);
        $award_id = 5;

        self::clubLeader($community_id, $award_id);
    }
}
