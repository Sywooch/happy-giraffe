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
    public function moveUserAlbumsPhotos()
    {
        $criteria = new \CDbCriteria();
        $criteria->compare('t.removed', 0);
        $criteria->compare('type', 0);
        $criteria->with = array('photos');

        $dp = new \CActiveDataProvider('Album', array(
            'criteria' => $criteria,
        ));
        $iterator = new \CDataProviderIterator($dp);
        foreach ($iterator as $album) {
            foreach ($album->photos as $photo) {
                $this->movePhoto($photo);
                \Yii::app()->db->active = false;
                \Yii::app()->db->active = true;
            }
        }
    }
    
    protected function movePhoto(\AlbumPhoto $oldPhoto)
    {
        if ($oldPhoto->newPhotoId !== null) {
            return $oldPhoto->newPhotoId;
        }

        if (! is_file($oldPhoto->getOriginalPath())) {
            return false;
        }

        $photo = new Photo();
        $photo->image = file_get_contents($oldPhoto->getOriginalPath());
        $photo->title = mb_substr($oldPhoto->title, 0, 150, 'UTF-8');
        $photo->original_name = $oldPhoto->file_name;
        $photo->created = $oldPhoto->created;
        $photo->updated = $oldPhoto->updated;
        $photo->author_id = $oldPhoto->author_id;
        if (! $photo->save()) {
            throw new \CException('Не удалось перенести фото');
        }
        \AlbumPhoto::model()->updateByPk($oldPhoto->id, array('newPhotoId' => $photo->id));
        return $photo->id;
    }

//    public function moveUserAlbums()
//    {
//        PhotoAlbum::model()->deleteAll();
//
//        $criteria = new \CDbCriteria();
//        $criteria->compare('removed', 0);
//        $criteria->compare('type', 0);
//        $criteria->compare('author_id', 12936);
//
//        $dp = new \CActiveDataProvider('Album', array(
//            'criteria' => $criteria,
//        ));
//        $iterator = new \CDataProviderIterator($dp);
//        foreach ($iterator as $album) {
//            $this->moveUserAlbum($album);
//        }
//    }
//
//    public function moveUser(\Album $oldAlbum)
//    {
//        $album = new PhotoAlbum();
//        $album->title = $oldAlbum->title;
//        $album->description = $oldAlbum->description;
//        $album->created = $oldAlbum->created;
//        $album->updated = $oldAlbum->updated;
//        $album->author_id = $oldAlbum->author_id;
//        $album->save();
//
//        $photosIds = array();
//        foreach ($oldAlbum->photos as $photo) {
//            $photosIds[] = $this->movePhoto($photo);
//        }
//
//        $album->getPhotoCollection()->attachPhotos($photosIds, true);
//    }
} 