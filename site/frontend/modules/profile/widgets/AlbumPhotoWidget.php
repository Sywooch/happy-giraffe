<?php

class AlbumPhotoWidget extends UserCoreWidget
{
    public $photos;
    public function init()
    {
        parent::init();

        $this->photos = AlbumPhoto::model()->findAll($this->getPhotosCriteria());
        $this->visible = !empty($this->photos);
    }

    private function getPhotosCriteria()
    {
        $criteria = new CDbCriteria;
        $criteria->with = array('album');
        $criteria->condition = 'album.type IN(0, 1, 3) AND t.author_id = :user_id';
        $criteria->params = array(':user_id' => $this->user->id);
        return $criteria;
    }
}
