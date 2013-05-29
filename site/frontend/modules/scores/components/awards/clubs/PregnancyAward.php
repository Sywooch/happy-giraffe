<?php
/**
 * Class PregnancyAward
 *
 * Орден Пузяшки
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class PregnancyAward extends CCommunityLeader
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $community_id = range(1,3);
        $award_id = ScoreAward::TYPE_PREGNANCY;

        self::clubLeader($community_id, $award_id);
    }
}
