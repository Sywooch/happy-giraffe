<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 29/10/13
 * Time: 16:55
 * To change this template use File | Settings | File Templates.
 */

class PostUsersWidget extends CWidget
{
    public $post;
    
    public function run()
    {
        $likedUsers = $this->post->getLikedUsers(33);
        $favouritedUsers = $this->post->getFavouritedUsers(33);
        $hasLike = ! Yii::app()->user->isGuest && HGLike::model()->hasLike($this->post, Yii::app()->user->id);
        $hasFavourite = ! Yii::app()->user->isGuest && Favourite::model()->getUserHas(Yii::app()->user->id, $this->post);
        $likesCount = HGLike::model()->countByEntity($this->post) - ($hasLike ? 1 : 0);
        $favouritedCount = Favourite::model()->getCountByModel($this->post) - ($hasFavourite ? 1 : 0);

        switch (get_class($this->post)) {
            case 'CommunityContent':
            case 'BlogContent':
                $class = $this->post->getIsFromBlog() ? 'BlogContent' : 'CommunityContent';
                $label = 'Запись';
                break;
            case 'AlbumPhoto':
                $class = get_class($this->post);
                $label = 'Фото';
                break;
            default:
                $class = get_class($this->post);
                $label = 'Страница';
        }

        if ($likedUsers || $favouritedUsers)
            $this->render('PostUsersWidget', compact('likedUsers', 'favouritedUsers', 'hasLike', 'hasFavourite', 'likesCount', 'favouritedCount', 'class', 'label'));
    }
}