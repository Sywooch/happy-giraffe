<?php
/**
 * Author: alexk984
 * Date: 28.09.12
 *
 * Орден “Отчаянная домохозяйка”
 */
class HouseWifeAward extends CCommunityLeader
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $community_id = array(23,26,28,34);
        $award_id = 23;

        self::clubLeader($community_id, $award_id);
    }
}
