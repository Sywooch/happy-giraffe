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
        $criteria->select = array('t.id');
        $criteria->with = array('rubric');
        $count = ($this->community_id == 22) ? SimpleRecipe::model()->count('section = 0') : CommunityContent::model()->count($criteria);

        $criteria->limit = 2;
        $criteria->with = array('rubric' => array(
            'select' => array('community_id')
        ), 'type' => array(
            'select' => array('slug')
        ));
        $criteria->select = array('t.id', 't.title', 'rubric_id');
        $criteria->compare('t.id', Favourites::getIdList(Favourites::BLOCK_THEME, 2, $this->community_id));
        $articles = CommunityContent::model()->findAll($criteria);

        $this->render('CommunityArticlesWidget', array(
            'articles' => $articles,
            'count' => $count,
            'title' => $this->title,
            'image' => $this->image,
            'community_id' => $this->community_id
        ));
    }
}