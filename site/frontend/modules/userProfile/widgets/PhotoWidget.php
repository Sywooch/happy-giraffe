<?php
/**
 * @author Никита
 * @date 26/12/14
 */

namespace site\frontend\modules\userProfile\widgets;


use site\frontend\modules\photo\models\PhotoAlbum;
use site\frontend\modules\photo\models\PhotoAttach;

class PhotoWidget extends \CWidget
{
    public $user;

    public function run()
    {
        $criteria = new \CDbCriteria(array(
            'with' => array(
                'photoCollections' => array(
                    'scopes' => array('notEmpty'),
                ),
            ),
            'scopes' => array(
                'user' => $this->user->id,
            ),
            'order' => 'RAND()',
        ));
        $album = PhotoAlbum::model()->find($criteria);
        $count = $this->getCount();
        $this->render('PhotoWidget', compact('album', 'count'));
    }

    protected function getCount()
    {
        $criteria = new \CDbCriteria();
        $criteria->select = 'COUNT(attaches.id) AS count';
        $criteria->with = array(
            'photoCollections' => array(
                'with' => array('attaches'),
            ),
        );
        $criteria->compare('t.author_id', $this->user->id);
        return PhotoAlbum::model()->count($criteria);
    }
} 