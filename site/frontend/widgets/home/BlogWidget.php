<?php

class BlogWidget extends CWidget
{
    public function run()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 6;
        $criteria->with = array('rubric' => array(
//            'select' => array('community_id', 'user_id'),
            'condition'=>'user_id IS NOT NULL'
        ), 'type' => array(
            'select' => array('slug')
        ),
            'contentAuthor' => array(
            'select' => array('id', 'avatar_id', 'first_name', 'last_name', 'online')
        ),'post','video','travel');
//        $criteria->select = array('t.id', 't.title', 't.type_id', 'rubric_id', 'author_id');
//        $criteria->condition = ' rubric.user_id IS NOT NULL ';
        $criteria->compare('t.id', Favourites::getIdListByDate(Favourites::BLOCK_BLOGS, 6));

        $contents = BlogContent::model()->findAll($criteria);
        $this->render('BlogWidget', compact('contents'));
    }
}
