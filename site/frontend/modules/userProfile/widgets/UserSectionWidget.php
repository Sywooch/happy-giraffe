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
        return Content::model()->byAuthor($this->user->id)->exists();
    }

    public function hasPhotos()
    {
        $criteria = new \CDbCriteria();
        $criteria->with = array(
            'photoCollections' => array(
                'scopes' => array('notEmpty'),
            ),
        );
        return PhotoAlbum::model()->exists($criteria);
    }

    public function hasFamily()
    {
        return Family::model()->hasMember($this->user->id)->exists();
    }
} 