<?php

namespace site\frontend\modules\userProfile\widgets;
use site\frontend\modules\posts\models\Content;
use site\frontend\modules\family\models\Family;
use site\frontend\modules\photo\models\PhotoAlbum;

/**
 * @author Никита
 * @date 28/10/14
 */

class UserSectionWidget extends \CWidget
{
    public $user;
    public $showToOwner = false;

    public function run()
    {
        if (! $this->show()) {
            return;
        }
        $this->render('UserSectionWidget', array('user' => $this->user));
    }

    protected function show()
    {
        return $this->showToOwner || ($this->user->id != \Yii::app()->user->id);
    }

    public function hasBlog()
    {
        $nPosts = Content::model()->byService('oldBlog')->byAuthor($this->user->id)->count();
        return $nPosts > 0;
    }

    public function hasPhotos()
    {
        $criteria = new \CDbCriteria();
        $criteria->with = array(
            'photoCollections' => array(
                'scopes' => array('notEmpty'),
            ),
        );
        $nAlbums = PhotoAlbum::model()->count($criteria);
        return $nAlbums > 0;
    }

    public function hasFamily()
    {
        return Family::model()->hasMember(\Yii::app()->user->id)->exists();
    }
} 