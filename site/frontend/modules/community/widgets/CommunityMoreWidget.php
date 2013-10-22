<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 10/17/13
 * Time: 4:59 PM
 * To change this template use File | Settings | File Templates.
 */

class CommunityMoreWidget extends CWidget
{
    public $content;

    public function run()
    {
        $favourites = $this->content->rubric->community->club->getFavourites(null, false);

        $photoPosts = array();
        $posts = array();
        foreach ($favourites as $f) {
            if ($f->id == $this->content->id)
                continue;

            if ($f->type_id == 3)
                $photoPosts[] = $f;
            elseif ($f->getPhoto() !== null)
                $posts[] = $f;
        }

        $resultPosts = array();
        if (! empty($photoPosts))
            $resultPosts[] = $photoPosts[array_rand($photoPosts)];
        if (! empty($posts))
            $resultPosts[] = $posts[array_rand($posts)];

        $this->render('CommunityMoreWidget', array('posts' => $resultPosts));
    }
}