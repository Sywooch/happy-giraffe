<?php
/**
 * Author: alexk984
 * Date: 06.04.12
 */
class MostPopularWidget extends SimpleWidget
{
    public function run(){
        $criteria = new CDbCriteria;
        $criteria->limit = 2;
        $criteria->with = array('rubric' => array(
            'select' => array('community_id', 'user_id'),
        ), 'type' => array(
            'select' => array('slug')
        ), 'post','video','travel');
        $criteria->select = array('t.id', 't.title', 't.type_id', 'rubric_id', 'author_id');
        $criteria->compare('t.id', Favourites::getIdListByDate(Favourites::BLOCK_INTERESTING, 2));

        $models = CommunityContent::model()->findAll($criteria);
        $this->render('MostPopularWidget', compact('models'));
    }
}