<?php
/**
 * Author: alexk984
 * Date: 01.03.12
 */
class CommunityArticlesWidget extends CWidget
{
    public $community_id;

    public function run()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('rubric.community_id', $this->community_id);
        $criteria->limit = 2;
        $criteria->order = ' RAND() ';
        $criteria->with = array('rubric');

        $articles = CommunityContent::model()->findAll($criteria);
        $count = CommunityContent::model()->count($criteria);

        $this->render('CommunitiesWidget', compact('articles', 'count'));
    }
}