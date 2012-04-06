<?php

class BlogWidget extends CWidget
{
    public function run()
    {
        $contents = BlogContent::model()->full()->findAll(array(
            'limit' => 6,
            'order' => 'created DESC',
            'condition' => 'rubric.user_id IS NOT NULL',
        ));

        $this->render('BlogWidget', compact('contents'));
    }
}
