<?php
/**
 * @author Никита
 * @date 20/10/14
 */

namespace site\frontend\modules\photo\components;


use site\frontend\modules\photo\models\Photo;
use site\frontend\modules\photo\models\PhotoAlbum;

class MigrateManager
{
    public function moveUserAlbums()
    {
        PhotoAlbum::model()->deleteAll();

        $criteria = new \CDbCriteria();
        $criteria->compare('removed', 0);
        $criteria->compare('type', 0);
        $criteria->compare('author_id', 12936);

        $dp = new \CActiveDataProvider('Album', array(
            'criteria' => $criteria,
        ));
        $iterator = new \CDataProviderIterator($dp);
        foreach ($iterator as $album) {
            $this->moveUserAlbum($album);
        }
    }

    public function moveUserAlbum(\Album $oldAlbum)
    {
        $album = new PhotoAlbum();
        $album->title = $oldAlbum->title;
        $album->description = $oldAlbum->description;
        $album->created = $oldAlbum->created;
        $album->updated = $oldAlbum->updated;
        $album->author_id = $oldAlbum->author_id;
        $album->save();

        $photosIds = array();
        foreach ($oldAlbum->photos as $photo) {
            $photo = $this->movePhoto($photo);
            $photosIds[] = $photo->id;
        }

        $album->getPhotoCollection()->attachPhotos($photosIds, true);
    }
    
    protected function movePhoto(\AlbumPhoto $oldPhoto)
    {
        $photo = new Photo();
        $photo->image = file_get_contents($oldPhoto->getOriginalPath());
        $photo->title = $oldPhoto->title;
        $photo->original_name = $oldPhoto->file_name;
        $photo->created = $oldPhoto->created;
        $photo->updated = $oldPhoto->updated;
        $photo->author_id = $oldPhoto->author_id;
        if (! $photo->save()) {
            throw new \CException('Не удалось перенести фото');
        }
        \Yii::app()->thumbs->createAll($photo);
        return $photo;
    }
} 