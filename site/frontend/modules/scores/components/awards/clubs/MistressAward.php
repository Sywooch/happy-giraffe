<?php
/**
 * Class MistressAward
 *
 * Орден Мастерицы
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class MistressAward extends CCommunityLeader
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $community_id = array(24,25);
        $award_id = ScoreAward::TYPE_MISTRESS;

        self::clubLeader($community_id, $award_id);
    }
}
