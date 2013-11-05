<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 10/25/13
 * Time: 3:30 PM
 * To change this template use File | Settings | File Templates.
 */

class PhotoPostWidget extends CWidget
{
    public $post;
    public $full;

    public function run()
    {
        $collection = new PhotoPostPhotoCollection(array('contentId' => $this->post->id));
        $coverPhoto = $this->post->gallery->getHorizontalOrFirst()->photo;

        $this->render('PhotoPostWidget', compact('collection', 'coverPhoto'));
    }
}