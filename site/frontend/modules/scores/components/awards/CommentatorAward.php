<?php
/**
 * Class CommentatorAward
 *
 * Лучший комментатор недели/месяца
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class CommentatorAward extends CAward
{
    public static function execute($period = CAward::PERIOD_MONTH)
    {
        echo "\n" . get_class() . "\n";

        if ($period == CAward::PERIOD_WEEK)
            $award_id = ScoreAward::TYPE_COMMENTATOR_WEEK;
        else
            $award_id = ScoreAward::TYPE_COMMENTATOR_MONTH;

        $rows = Yii::app()->db->createCommand()
            ->select('t.author_id, count(t.id) as count')
            ->from(Comment::model()->tableName() . ' as t')
            ->where(self::getTimeCondition($period).' AND t.removed=0')
            ->group('t.author_id')
            ->order('count DESC')
            ->limit(10)
            ->queryAll();

        foreach ($rows as $row)
            if ($row['count'] == $rows[0]['count'])
                self::giveAward($row['author_id'], $award_id);
    }
}
