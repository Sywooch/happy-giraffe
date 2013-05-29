<?php
/**
 * Author: alexk984
 * Date: 28.09.12
 *
 * Фотофан
 */
class PhotoAward extends CAward
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $award_id = 20;

        $criteria = self::getCriteria();
        $criteria->order = 'COUNT(t.id) DESC';
        $criteria->with = array('album' => array('condition'=>'album.type = 0 OR album.type = 1'));

        $model = AlbumPhoto::model()->find($criteria);
        $max_count = $model->count;
        self::showMaxPostsCount($max_count);

        $criteria = self::getCriteria();
        $criteria->with = array('album' => array('condition'=>'album.type = 0 OR album.type = 1'));

        self::awardByMaxCount($criteria, $max_count, $award_id, 'AlbumPhoto');
    }
}
