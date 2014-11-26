<?php
/**
 * @author Никита
 * @date 20/10/14
 */

namespace site\frontend\modules\photo\components;


use site\frontend\modules\photo\models\Photo;
use site\frontend\modules\photo\models\PhotoAlbum;
use site\frontend\modules\photo\models\PhotoAttach;
use site\frontend\modules\photo\models\PhotoCollection;

class MigrateManager
{
    public static function syncPhotoPostCollection(\CommunityContent $post)
    {
        if ($post->gallery === null || empty($post->gallery->items))
        {
            return false;
        }

        $photoIds = array();
        foreach ($post->gallery->items as $item)
        {
            if ($photoId = self::movePhoto($item->photo, array('title' => $item->photo->title, 'description' => $item->description)))
                $photoIds[] = $photoId;
        }
        if (empty($photoIds))
            $photoIds[] = 3;
        $collection = $post->getPhotoCollection();
        $collection->attachPhotos($photoIds, true);

        return $collection;
    }

    public static function getByRelation($oldModel, $relation = 'photos')
    {
        $photosIds = array();
        foreach ($oldModel->$relation as $oldAttach) {
            $photoId = self::movePhoto($oldAttach->photo);
            if ($photoId !== false) {
                $photosIds[] = $photoId;
            }
        }
        return $photosIds;
    }


    public static function moveUserAlbumsPhotos($id)
    {
        $criteria = new \CDbCriteria();
        $criteria->compare('t.removed', 0);
        $criteria->compare('type', 0);
        $criteria->with = array('photos');
        $criteria->order = 't.id ASC';

        if ($id !== null) {
            $criteria->compare('t.id', '>=' . $id);
        }

        $dp = new \CActiveDataProvider('Album', array(
            'criteria' => $criteria,
        ));
        $total = $dp->totalItemCount;

        $iterator = new \CDataProviderIterator($dp);
        foreach ($iterator as $i => $album) {
            $newAlbum = new PhotoAlbum();
            $newAlbum->detachBehavior('HTimestampBehavior');
            $newAlbum->title = $album->title;
            $newAlbum->description = $album->description;
            $newAlbum->author_id = $album->author_id;
            $newAlbum->created = $album->created;
            $newAlbum->updated = $album->updated;
            $newAlbum->save(false);

            $photoIds = array();
            foreach ($album->photos as $photo) {
                $photoId = self::movePhoto($photo);
                if ($photoId !== false) {
                    $photoIds[] = $photoId;
                }
            }
            $collection = $newAlbum->photoCollection;
            $collection->detachBehavior('HTimestampBehavior');
            $collection->attachPhotos($photoIds);
            PhotoCollection::model()->updateByPk($collection->id, array(
                'created' => $album->created,
                'updated' => $album->updated,
            ));

            echo '[' . ($i + 1) . '/' . $total . ']' . ' - ' . $album->id  . "\n";

            \Yii::app()->db->active = false;
            \Yii::app()->db->active = true;

            \Album::model()->updateByPk($album->id, array('newAlbumId' => $newAlbum->id));
        }
    }
    
    public static function movePhoto(\AlbumPhoto $oldPhoto, $attributes = array())
    {
        if ($oldPhoto->newPhotoId !== null) {
            return $oldPhoto->newPhotoId;
        }

        if (! is_file($oldPhoto->getOriginalPath())) {
            return false;
        }

        $photo = new Photo();
        $photo->image = file_get_contents($oldPhoto->getOriginalPath());
        $photo->original_name = $oldPhoto->file_name;
        $photo->created = $oldPhoto->created;
        $photo->updated = $oldPhoto->updated;
        $photo->author_id = $oldPhoto->author_id;
        self::updatePhotoInfo($oldPhoto, $photo, $attributes);
        if (! $photo->save()) {
            echo "error\n";
            return false;
        }

        \Yii::app()->db->active = false;
        \Yii::app()->db->active = true;

        var_dump($photo->id);
        var_dump(\Yii::app()->db->getCurrentTransaction());
        var_dump(Photo::model()->findByPk($photo->id));

        \AlbumPhoto::model()->updateByPk($oldPhoto->id, array('newPhotoId' => $photo->id));
        return $photo->id;
    }

    public static function updatePhoto(\AlbumPhoto $oldPhoto, $attributes = array())
    {
        if (($photo = $oldPhoto->newPhoto) === null) {
            return false;
        }

        self::updatePhotoInfo($oldPhoto, $photo, $attributes);
        $updateAttributes = array_merge(array_keys($attributes), array('title'));
        return $photo->update($updateAttributes);
    }

    protected static function updatePhotoInfo(\AlbumPhoto $oldPhoto, Photo &$photo, $attributes)
    {
        foreach ($attributes as $attribute => $value) {
            if ($attribute == 'title') {
                $photo->title = mb_substr($oldPhoto->title, 0, 150, 'UTF-8');
            } else {
                $photo->$attribute = $value;
            }
        }
    }
} 