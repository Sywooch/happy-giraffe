<?php

/**
 * Class PopularPostsWidget
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class PopularPostsWidget extends CWidget
{
    public function run()
    {
        $popular_posts_count = UserAttributes::get(Yii::app()->user->id, 'popular_posts_count');
        $models = Favourites::getArticlesByDate(Favourites::BLOCK_INTERESTING, date("Y-m-d"), 6);
        $popular_hide = UserAttributes::get(Yii::app()->user->id, 'popular_hide');

        if ($popular_posts_count < count($models) && !$popular_hide) {
            $posts = array_slice($models, $popular_posts_count, 2);

            UserAttributes::set(Yii::app()->user->id, 'popular_posts_count', $popular_posts_count + 2);
            $this->render('PopularPostsWidget', array('posts' => $posts));
        }
    }
}
