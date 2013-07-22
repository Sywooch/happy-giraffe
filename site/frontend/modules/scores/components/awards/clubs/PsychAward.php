<?php
/**
 * Class PsychAward
 *
 * “Семейный психолог”
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class PsychAward extends CCommunityLeader
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $community_id = 32;
        $award_id = ScoreAward::TYPE_PSYCHO;

        self::clubLeader($community_id, $award_id);
    }
}
