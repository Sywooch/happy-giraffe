<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 16/09/14
 * Time: 11:19
 */

namespace site\frontend\modules\photo\components\attaches;


use site\frontend\modules\photo\components\AlbumPhotoCollectionBehavior;
use site\frontend\modules\photo\components\UserPhotoCollectionBehavior;
use site\frontend\modules\photo\models\PhotoAlbum;
use site\frontend\modules\photo\models\PhotoCollection;

class AlbumUploadAttachManager extends AttachManager
{
    public $albumId;

    public function __construct($albumId)
    {
        $this->albumId = $albumId;
        $album = PhotoAlbum::model()->findByPk($this->albumId);

        $collections = array();
        $collections[] = PhotoCollection::model()->findByAttributes(array(
            'entity_id' => $this->albumId,
            'entity' => 'PhotoAlbum',
            'key' => AlbumPhotoCollectionBehavior::KEY_ALL_PHOTOS,
        ));
        $collections[] = PhotoCollection::model()->findByAttributes(array(
            'entity_id' => $album->author_id,
            'entity' => 'User',
            'key' => UserPhotoCollectionBehavior::KEY_ALL_PHOTOS,
        ));
    }
} 