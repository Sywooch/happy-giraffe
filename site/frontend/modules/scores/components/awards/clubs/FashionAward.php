<?php
/**
 * Author: alexk984
 * Date: 28.09.12
 *
 * Орден  Коко Шанель
 *
 */
class FashionAward extends CCommunityLeader
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $community_id = 30;
        $award_id = 4;

        self::clubLeader($community_id, $award_id);
    }
}
