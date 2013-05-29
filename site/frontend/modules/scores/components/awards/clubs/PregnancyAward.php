<?php
/**
 * Author: alexk984
 * Date: 28.09.12
 *
 * Орден Пузяшки
 */
class PregnancyAward extends CCommunityLeader
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $community_id = range(1,3);
        $award_id = 28;

        self::clubLeader($community_id, $award_id);
    }
}
