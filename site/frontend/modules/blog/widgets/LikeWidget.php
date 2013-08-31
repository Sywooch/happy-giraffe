<?php
/**
 * Виджет лайка поста
 * 
 * @author Alex Kireev <alexk984@gmail.com>
 */
class LikeWidget extends CWidget {
    /**
     * @var CommunityContent
     */
    public $model;

    public function run()
    {
        $count = (int) PostRating::likesCount($this->model);
        $active = !Yii::app()->user->isGuest && Yii::app()->user->getModel()->isLiked($this->model);

        $this->render('like', compact('count', 'active'));
    }
}