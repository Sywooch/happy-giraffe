<?php
/**
 * Class CookAward
 *
 * Лучший кулинар
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class CookAward extends CAward
{
    public static function execute()
    {
        Yii::import('site.frontend.modules.cook.models.*');

        echo "\n" . get_class() . "\n";

        $award_id = ScoreAward::TYPE_COOK;

        $rows = Yii::app()->db->createCommand()
            ->select('t.author_id, count(t.id) as count')
            ->from(CookRecipe::model()->tableName() . ' as t')
            ->where(self::getMonthCondition().' AND t.removed=0')
            ->group('t.author_id')
            ->order('count DESC')
            ->limit(10)
            ->queryAll();

        foreach ($rows as $row)
            if ($row['count'] == $rows[0]['count'])
                self::giveAward($row['author_id'], $award_id);
    }
}
