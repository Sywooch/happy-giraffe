<?php
/**
 * Популярное в блогах
 *
 * Новые статьи с самым высоким рейтингом.
 *
 * Author: choo
 * Date: 13.05.2012
 */
class BlogPopularWidget extends CWidget
{
    public function run()
    {
        $blogContents = BlogContent::model()->findAll(array(
            'with' => array('rubric'),
            'limit' => 3,
            'order' => 'rate DESC',
            'condition' => 'rubric.user_id IS NOT NULL AND DATE_SUB(CURDATE(), INTERVAL 3 DAY) <= created',
        ));
        $this->render('BlogPopularWidget', compact('blogContents'));
    }
}
