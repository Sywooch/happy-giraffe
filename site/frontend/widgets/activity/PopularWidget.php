<?php
/**
 * Популярное в клубах/блогах
 *
 * Новые статьи с самым высоким рейтингом.
 *
 * Author: choo
 * Date: 13.05.2012
 */
class PopularWidget extends CWidget
{
    public function run()
    {
        $communityContents = CommunityContent::model()->full()->findAll(array(
            'limit' => 3,
            'order' => 'rate DESC',
            'condition' => 'rubric.community_id IS NOT NULL AND DATE_SUB(CURDATE(), INTERVAL 3 DAY) <= created',
        ));
        $blogContents = BlogContent::model()->full()->findAll(array(
            'limit' => 3,
            'order' => 'rate DESC',
            'condition' => 'rubric.user_id IS NOT NULL AND DATE_SUB(CURDATE(), INTERVAL 3 DAY) <= created',
        ));
        $this->render('PopularWidget', compact('communityContents', 'blogContents'));
    }
}
