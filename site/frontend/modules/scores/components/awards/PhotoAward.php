<?php
/**
 * Class PhotoAward
 *
 * Фотофан
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class PhotoAward extends CAward
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $award_id = ScoreAward::TYPE_PHOTO;

        $rows = Yii::app()->db->createCommand()
            ->select('t.author_id, count(t.id) as count')
            ->from(AlbumPhoto::model()->tableName() . ' as t')
            ->where(self::getMonthCondition().' AND t.removed=0 AND (album.type = 0 OR album.type = 1)')
            ->join('album__albums as album', 'album.id = t.album_id')
            ->group('t.author_id')
            ->order('count DESC')
            ->limit(10)
            ->queryAll();

        foreach ($rows as $row)
            if ($row['count'] == $rows[0]['count'])
                self::giveAward($row['author_id'], $award_id);
    }
}
