<?php
/**
 * Популярное в клубах
 *
 * Новые статьи с самым высоким рейтингом.
 *
 * Author: choo
 * Date: 13.05.2012
 */
class CommunityPopularWidget extends CWidget
{
    public function run()
    {
        $communityContents = CommunityContent::model()->findAll(array(
            'with'=>array('rubric'),
            'limit' => 3,
            'order' => 'rate DESC',
            'condition' => 'rubric.community_id IS NOT NULL AND DATE_SUB(CURDATE(), INTERVAL 3 DAY) <= created AND author_id != :happy_giraffe',
            'params' => array(':happy_giraffe' => User::HAPPY_GIRAFFE),
        ));

        $this->render('CommunityPopularWidget', compact('communityContents'));
    }
}
