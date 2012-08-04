<?php
/**
 * Author: alexk984
 * Date: 02.08.12
 */
class WeeklyArticlesWidget extends CWidget
{
    public function run()
    {
        $articles = Favourites::model()->getWeekPosts();
        $this->render('weekly_news', array('models'=>$articles));
    }
}
