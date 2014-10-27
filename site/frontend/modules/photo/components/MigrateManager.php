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
    public static function syncPhotoPostCollection(\CommunityContent $post)
    {
        if ($post->gallery === null || empty($post->gallery->items))
        {
            return false;
        }

        $photoIds = array();
        foreach ($post->gallery->items as $item)
        {
            if ($photoId = self::movePhoto($item->photo))
                $photoIds[] = $photoId;
        }
        if (empty($photoIds))
            $photoIds[] = 3;
        $collection = $post->getPhotoCollection();
        $collection->attachPhotos($photoIds, true);

        return $collection;
    }


    public static function moveUserAlbumsPhotos()
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
                echo $photo->id . "\n";
                self::movePhoto($photo);
            }
            \Yii::app()->db->active = false;
            \Yii::app()->db->active = true;
        }
    }
    
    public static function movePhoto(\AlbumPhoto $oldPhoto)
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
            echo "error\n";
            return false;
        }

        \Yii::app()->db->active = false;
        \Yii::app()->db->active = true;

        \AlbumPhoto::model()->updateByPk($oldPhoto->id, array('newPhotoId' => $photo->id));
        return $photo->id;
    }
} 