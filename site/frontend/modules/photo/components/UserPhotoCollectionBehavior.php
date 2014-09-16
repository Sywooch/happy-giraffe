<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 16/09/14
 * Time: 11:37
 */

namespace site\frontend\modules\photo\components;


class UserPhotoCollectionBehavior extends PhotoCollectionBehavior
{
    const KEY_ALL_PHOTOS = 'all';
    const KEY_UNSORTED_PHOTOS = 'unsorted';

    public function getKeys()
    {
        return array(
            self::KEY_ALL_PHOTOS,
            self::KEY_UNSORTED_PHOTOS,
        );
    }
} 