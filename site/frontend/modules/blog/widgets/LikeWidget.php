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
    public $class;

    public function run()
    {
        $count = (int) PostRating::likesCount($this->model);
        $active = !Yii::app()->user->isGuest && Yii::app()->user->getModel()->isLiked($this->model);

        $this->class = get_class($this->model);
        if ($this->class == 'CommunityContent' && $this->model->getIsFromBlog())
            $this->class = 'BlogContent';
        elseif($this->class == 'BlogContent' && !$this->model->getIsFromBlog())
            $this->class = 'CommunityContent';

        $this->render('like', compact('count', 'active'));
    }
}