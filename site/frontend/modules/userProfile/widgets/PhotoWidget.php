<?php
/**
 * @author Никита
 * @date 26/12/14
 */

namespace site\frontend\modules\userProfile\widgets;


use site\frontend\modules\photo\models\PhotoAlbum;

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
        $this->render('PhotoWidget', compact($album));
    }
} 