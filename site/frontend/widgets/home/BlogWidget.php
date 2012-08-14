<?php

class BlogWidget extends CWidget
{
    public function run()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 6;
        $criteria->with = array('rubric' => array(
            'select' => array('community_id', 'user_id'),
            'condition'=>'user_id IS NOT NULL'
        ), 'type' => array(
            'select' => array('slug')
        ), 'post' => array(
            'select' => array('text')
        ), 'contentAuthor' => array(
            'select' => array('id', 'avatar_id', 'first_name', 'last_name', 'online')
//        ), 'contentAuthor.avatar' => array(
//            'select' => array('id', 'file_name', 'fs_name')
        ),'video','travel');
        $criteria->select = array('t.id', 't.title', 't.type_id', 'rubric_id', 'author_id');
//        $criteria->condition = ' rubric.user_id IS NOT NULL ';
        $criteria->compare('t.id', Favourites::getIdList(Favourites::BLOCK_BLOGS, 6));

        $contents = BlogContent::model()->findAll($criteria);
        $this->render('BlogWidget', compact('contents'));
    }
}
