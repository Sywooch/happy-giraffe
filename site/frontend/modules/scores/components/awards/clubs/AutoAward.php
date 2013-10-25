<?php
/**
 * Class AutoAward
 *
 * Автолюбитель
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class AutoAward extends CCommunityLeader
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $community_id = 27;
        $award_id = ScoreAward::TYPE_AUTO;

        self::clubLeader($community_id, $award_id);
    }
}
