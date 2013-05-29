<?php
/**
 * Author: alexk984
 * Date: 28.09.12
 *
 * Лучший кулинар
 */

Yii::import('site.frontend.modules.cook.models.*');

class CookAward extends CAward
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $award_id = 9;

        $criteria = self::getCriteria();
        $criteria->order = 'COUNT(t.id) DESC';
        $criteria->scopes = null;

        $model = CookRecipe::model()->find($criteria);
        $max_count = $model->count;
        self::showMaxPostsCount($max_count);

        $criteria = self::getCriteria();
        $criteria->scopes = null;

        self::awardByMaxCount($criteria, $max_count, $award_id, 'CookRecipe');
    }
}
