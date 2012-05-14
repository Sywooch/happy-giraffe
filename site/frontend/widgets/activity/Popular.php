<?php
/**
 * Author: choo
 * Date: 13.05.2012
 */
class Popular extends CWidget
{
    public function run()
    {
        $communityContents = CommunityContent::model()->full()->findAll(array(
            'limit' => 3,
            'order' => 'rate DESC',
            'condition' => 'rubric.community_id IS NOT NULL',
        ));
        $blogContents = BlogContent::model()->full()->findAll(array(
            'limit' => 3,
            'order' => 'rate DESC',
            'condition' => 'rubric.user_id IS NOT NULL',
        ));
        $this->render('Popular', compact('communityContents', 'blogContents'));
    }
}
