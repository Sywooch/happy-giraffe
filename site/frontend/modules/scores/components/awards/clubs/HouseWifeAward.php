<?php
/**
 * Class HouseWifeAward
 *
 * Орден “Отчаянная домохозяйка”
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class HouseWifeAward extends CCommunityLeader
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $community_id = 28;
        $award_id = ScoreAward::TYPE_HOUSEWIFE;

        self::clubLeader($community_id, $award_id);
    }
}
