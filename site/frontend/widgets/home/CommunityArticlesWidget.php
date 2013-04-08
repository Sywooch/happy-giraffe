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
        $articles = array();

        $this->render('CommunityArticlesWidget', array(
            'articles' => $articles,
            'count' => 0,
            'title' => $this->title,
            'image' => $this->image,
            'community_id' => $this->community_id
        ));
    }
}