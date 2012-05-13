<?php
/**
 * Author: choo
 * Date: 13.05.2012
 */
class Popular extends CWidget
{
    public function run()
    {
        $communityContents = Rating::model()->findTopWithEntity(CommunityContent::model()->full(), 3);
        $blogContents = Rating::model()->findTopWithEntity(BlogContent::model()->full(), 3);
        $this->render('Popular', compact('communityContents', 'blogContents'));
    }
}
