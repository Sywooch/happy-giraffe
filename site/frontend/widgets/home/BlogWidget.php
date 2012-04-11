<?php

class BlogWidget extends CWidget
{
    public function run()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 6;
        //$criteria->order = ' created DESC ';
        $criteria->condition = ' rubric.user_id IS NOT NULL ';
        $criteria->compare('t.id', Favourites::getIdList(Favourites::BLOCK_BLOGS, 6));

        $contents = BlogContent::model()->full()->findAll($criteria);
        $this->render('BlogWidget', compact('contents'));
    }
}
