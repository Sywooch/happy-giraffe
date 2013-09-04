<?php
/**
 * Class FriendAward
 *
 * Самый общительный
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class FriendAward extends CAward
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";
        $award_id = ScoreAward::TYPE_FRIEND;

        $rows = Yii::app()->db->createCommand()
            ->select('t.user_id, count(t.id) as count')
            ->from(Friend::model()->tableName() . ' as t')
            ->where(self::getMonthCondition())
            ->group('t.user_id')
            ->order('count DESC')
            ->limit(10)
            ->queryAll();

        foreach ($rows as $row)
            if ($row['count'] == $rows[0]['count'])
                self::giveAward($row['user_id'], $award_id);
    }
}
