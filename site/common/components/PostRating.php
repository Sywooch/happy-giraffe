<?php
/**
 * insert Description
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class PostRating
{
    /**
     * @var PostRating
     */
    private static $_instance;
    /**
     * @var CommunityContent
     */
    private $model;

    /**
     * @return PostRating
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    private function __construct()
    {
    }

    /**
     * @param CActiveRecord $model
     */
    public function reCalc($model)
    {
        if (get_class($model) != 'CommunityContent')
            return ;

        $this->model = $model;
        $model->rating = $this->repost() + $this->likes() + $this->favourites() + $this->comments() + $this->views();
        $model->update(array('rating'));
    }

    /**
     * @return int
     */
    private function repost()
    {
        return CommunityContent::model()->count('repost_id=' . $this->model->id);
    }

    /**
     * @return int
     */
    private function likes()
    {
        return RatingYohoho::model()->countByEntity($this->model);
    }

    /**
     * @return int
     */
    private function favourites()
    {
        return Favourite::model()->getCountByModel($this->model);
    }

    /**
     * @return int
     */
    private function comments()
    {
        return floor($this->model->getUnknownClassCommentsCount() * 0.2);
    }

    /**
     * @return int
     */
    private function views()
    {
        return floor(PageView::model()->viewsByPath($this->model->getUrl()) * 0.01);
    }
}