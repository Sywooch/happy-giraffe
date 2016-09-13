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
            if ($photo = self::movePhoto($item->photo, array('title' => $item->photo->title, 'description' => $item->description))) {
                $photoIds[] = $photo->id;
            }
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
            if ($photo = self::movePhoto($oldAttach->photo)) {
                $photosIds[] = $photo->id;
            }
        }
        return $photosIds;
    }


    public static function moveUserAlbumsPhotos($id)
    {
        $criteria = new \CDbCriteria();
        $criteria->compare('t.removed', 0);
        $criteria->compare('type', 1);
        $criteria->addCondition('newAlbumId IS NULL');
        $criteria->with = array('photos');
        $criteria->order = 't.id ASC';

        if ($id !== null) {
            $criteria->compare('t.id', '>=' . $id);
        }

        $dp = new \CActiveDataProvider('Album', array(
            'criteria' => $criteria,
        ));
        $total = $dp->totalItemCount;

        $iterator = new \CDataProviderIterator($dp, 100);
        foreach ($iterator as $i => $album) {
            if ($album->newAlbumId !== null) {
                continue;
            }

            $transaction = \Yii::app()->db->beginTransaction();
            try {
                $newAlbum = new PhotoAlbum();
                $newAlbum->detachBehavior('HTimestampBehavior');
                $newAlbum->title = $album->title;
                $newAlbum->description = $album->description;
                $newAlbum->author_id = $album->author_id;
                $newAlbum->created = $album->created;
                $newAlbum->updated = $album->updated;
                $newAlbum->source = 'privateAlbum';
                $newAlbum->save(false);

                $photoIds = array();
                foreach ($album->photos as $photo) {
                    if ($newPhoto = self::movePhoto($photo)) {
                        $photoIds[] = $newPhoto->id;
                    }
                }
                $collection = $newAlbum->photoCollection;
                $collection->detachBehavior('HTimestampBehavior');
                $collection->attachPhotos($photoIds);
                PhotoCollection::model()->updateByPk($collection->id, array(
                    'created' => $album->created,
                    'updated' => $album->updated,
                ));

                echo '[' . ($i + 1) . '/' . $total . ']' . ' - ' . $album->id . "\n";

                \Album::model()->updateByPk($album->id, array('newAlbumId' => $newAlbum->id));
                $transaction->commit();
            } catch (\Exception $e) {
                echo time() . "\n";
                $transaction->rollback();
                throw $e;
            }
        }
    }

    public static function movePhoto(\AlbumPhoto &$oldPhoto, $attributes = array())
    {
        \CommentLogger::model()->addToLog('MigrateManager', 'start movePhoto()');
        if ($oldPhoto->newPhotoId !== null) {
            \CommentLogger::model()->addToLog('MigrateManager', 'newPhotoId is not null: ' . $oldPhoto->newPhotoId);
            $objPhoto = (new Photo())->findByPk($oldPhoto->newPhotoId);
            if (is_object($objPhoto))
            {
                return $objPhoto;
            }

            \CommentLogger::model()->addToLog('MigrateManager', '!!Ahtung!! objPhoto not exist by id: ' . $oldPhoto->newPhotoId);
            return $oldPhoto->newPhoto;
        }

        if (! is_file($oldPhoto->getOriginalPath())) {
            \CommentLogger::model()->addToLog('MigrateManager', 'getOriginalPath is not file, return false');
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
            \CommentLogger::model()->addToLog('MigrateManager', '$photo is not save!, return false');
            return false;
        }

        $oldPhoto->newPhotoId = $photo->id;
        \AlbumPhoto::model()->updateByPk($oldPhoto->id, array('newPhotoId' => $photo->id));
        \CommentLogger::model()->addToLog('MigrateManager', '$photo is saved, id: ' . $photo->id);
        return $photo;
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