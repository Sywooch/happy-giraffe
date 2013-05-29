<?php
/**
 * Class DoctorAward
 *
 * Орден Доктора Айболита
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class DoctorAward extends CCommunityLeader
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $community_id = 33;
        $award_id = ScoreAward::TYPE_DOCTOR;

        self::clubLeader($community_id, $award_id);
    }
}
