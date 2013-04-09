<?php

class BlogWidget extends CWidget
{
    public function run()
    {
        $models = Favourites::getArticlesByDate(Favourites::BLOCK_BLOGS, date("Y-m-d"), 6);
        $this->render('BlogWidget', compact('models'));
    }
}
