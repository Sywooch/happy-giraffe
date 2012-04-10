<?php
/**
 * Author: alexk984
 * Date: 01.03.12
 */
class CommunityArticlesWidget extends CWidget
{
    public $community_id;
    public $title;
    public $image;

    public function run()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('rubric.community_id', $this->community_id);
        $criteria->limit = 2;
        $criteria->with = array('rubric');
        $criteria->order = ' RAND() ';
        $count = CommunityContent::model()->count($criteria);

        $criteria->compare('t.id', Favourites::getIdList(Favourites::BLOCK_THEME));
        $articles = CommunityContent::model()->full()->findAll($criteria);

        $this->render('CommunityArticlesWidget', array(
            'articles'=>$articles,
            'count'=>$count,
            'title'=>$this->title,
            'image'=>$this->image,
            'community_id'=>$this->community_id
        ));
    }
}