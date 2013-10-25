<?php
/**
 * Расчет рейтинга поста и его показателей
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class PostRating
{
    /**
     * Пересчет рейтинга после добавления комментария к записи
     * пересчитываем рейтинг только если кол-во комментариев кратно 5-ти
     *
     * @param Comment $comment
     */
    public static function reCalcFromComments($comment)
    {
        $commentsCount = Yii::app()->db->createCommand()
            ->select('count(*)')
            ->from('comments')
            ->where('entity=:entity AND entity_id=:entity_id AND removed = 0',
                array(':entity' => $comment->entity, ':entity_id' => $comment->entity_id))
            ->queryScalar();
        if ($commentsCount % 5 == 0)
            PostRating::reCalc($comment->relatedModel);
    }

    /**
     * Пересчет рейтинга после просмотра записи
     *
     * @param CommunityContent $model
     */
    public static function reCalcFromViews($model)
    {
        $count = PageView::model()->viewsByPath($model->getUrl());
        if ($count % 50 == 0)
            PostRating::reCalc($model);
    }

    /**
     * @param CActiveRecord $model
     */
    public static function reCalc($model)
    {
        if (in_array(get_class($model), array('CommunityContent', 'BlogContent', 'AlbumPhoto'))) {
            if (method_exists($model, 'getIsFromBlog')) {
                if ($model->getIsFromBlog())
                    $model = BlogContent::model()->findByPk($model->id);
                else
                    $model = CommunityContent::model()->findByPk($model->id);
            } else
                $model = AlbumPhoto::model()->findByPk($model->id);

            if ($model) {
                $model->rate = round(self::repostCount($model) + self::likesCount($model) + self::favouritesCount($model)
                + self::comments($model) + self::views($model));
                $model->update(array('rate'));
            }
        }
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
        return HGLike::model()->countByEntity($model);
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
        return floor($model->commentsCount * 0.2);
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