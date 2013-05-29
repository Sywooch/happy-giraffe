<?php
/**
 * Author: alexk984
 * Date: 28.09.12
 *
 * Лучший комментатор недели/месяца
 */
class CommentatorAward extends CAward
{
    public static function execute($week = false)
    {
        echo "\n" . get_class() . "\n";

        $award_id = 10;
        $criteria = self::getCriteria($week);
        $criteria->order = 'COUNT(t.id) DESC';
        $criteria->condition .= ' AND entity != "User"';
        $model = Comment::model()->find($criteria);
        $max_count = $model->count;
        self::showMaxPostsCount($max_count);

        $criteria = self::getCriteria($week);
        $criteria->condition .= ' AND entity != "User"';

        self::awardByMaxCount($criteria, $max_count, $award_id, 'Comment');
    }
}
