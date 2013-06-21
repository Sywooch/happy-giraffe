<?php
/**
 * Расчет рейтинга поста и его показателей
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class PostRating
{
    /**
     * @param CActiveRecord $model
     */
    public static function reCalc($model)
    {
        if (get_class($model) != 'CommunityContent')
            return ;

        $model->rating = self::repostCount($model) + self::likesCount($model) + self::favouritesCount($model)
            + self::comments($model) + self::views($model);
        $model->update(array('rating'));
    }

    /**
     * @param CommunityContent $model
     * @return int
     */
    public static function repostCount($model)
    {
        return CommunityContent::model()->count('source_id=' . $model->id);
    }

    /**
     * @param CommunityContent $model
     * @return int
     */
    public static function likesCount($model)
    {
        return RatingYohoho::model()->countByEntity($model);
    }

    /**
     * @param CommunityContent $model
     * @return int
     */
    public static function favouritesCount($model)
    {
        return Favourite::model()->resetScope()->getCountByModel($model);
    }

    /**
     * @param CommunityContent $model
     * @return int
     */
    public static function comments($model)
    {
        return floor($model->getUnknownClassCommentsCount() * 0.2);
    }

    /**
     * @param CommunityContent $model
     * @return int
     */
    public static function views($model)
    {
        return floor(PageView::model()->viewsByPath($model->getUrl()) * 0.01);
    }
}