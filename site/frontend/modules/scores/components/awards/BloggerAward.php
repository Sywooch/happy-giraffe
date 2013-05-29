<?php
/**
 * Author: alexk984
 * Date: 28.09.12
 *
 * Лучший блогер недели/месяца
 */
class BloggerAward extends CAward
{
    public static function execute($week = false)
    {
        echo "\n" . get_class() . "\n";

        $criteria = self::getBloggerCriteria($week);
        $criteria->order = 'COUNT(t.id) DESC';
        $model = CommunityContent::model()->find($criteria);
        $max_count = $model->count;
        self::showMaxPostsCount($max_count);

        $criteria = self::getBloggerCriteria($week);
        ($week) ? self::awardByMaxCount($criteria, $max_count, 1) : self::awardByMaxCount($criteria, $max_count, 2);
    }

    public static function getBloggerCriteria($week = false)
    {
        $criteria = self::getCriteria($week);
        $criteria->with = array(
            'rubric' => array(
                'condition' => 'rubric.user_id IS NOT NULL'
            )
        );

        return $criteria;
    }
}
