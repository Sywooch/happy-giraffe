<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 16/09/14
 * Time: 11:30
 */

namespace site\frontend\modules\photo\components;


use site\frontend\modules\photo\models\PhotoCollection;

class AlbumPhotoCollectionBehavior extends PhotoCollectionBehavior
{
    const KEY_ALL_PHOTOS = 'all';

    public function getKeys()
    {
        return array(
            self::KEY_ALL_PHOTOS,
        );
    }
} 