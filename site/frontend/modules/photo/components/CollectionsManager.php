<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 24/09/14
 * Time: 09:48 AM
 */

namespace site\frontend\modules\photo\components;


use site\frontend\modules\photo\models\PhotoAttach;
use site\frontend\modules\photo\models\PhotoCollection;

class CollectionsManager
{
    public static function addPhotos($collection, $photos)
    {
        $collection = self::loadCollection($collection);

        if (! \Yii::app()->user->checkAccess('addPhotos', compact('collection'))) {
            throw new \CException('Недостаточно прав');
        }

        $success = true;

        $collection->attachPhotos($photos);
    }

    public static function moveAttaches($sourceCollection, $destinationCollection, $attaches)
    {
        $sourceCollection = self::loadCollection($sourceCollection);
        $destinationCollection = self::loadCollection($destinationCollection);

        if (! \Yii::app()->user->checkAccess('moveAttaches', compact('sourceCollection', 'destinationCollection'))) {
            throw new \CException('Недостаточно прав');
        }

        $criteria = new \CDbCriteria();
        $criteria->compare('t.collection_id', $sourceCollection);
        $criteria->addInCondition('t.id', $attaches);

        return PhotoAttach::model()->updateAll(array(
            'collection_id' => $destinationCollection,
        )) == count($attaches);
    }

    public static function sort($collection, $attaches)
    {
        $collection = self::loadCollection($collection);

        if (! \Yii::app()->user->checkAccess('sortPhotoCollection', compact('collection'))) {
            throw new \CException('Недостаточно прав');
        }

        $success = true;
        foreach ($attaches as $i => $attachId) {
            $success = $success && PhotoAttach::model()->updateByPk($attachId, array('position' => $i));
        }
        return $success;
    }

    protected static function loadCollection($collection)
    {
        if (! $collection instanceof PhotoCollection) {
            $collection = PhotoCollection::model()->findByPk($collection);
            if ($collection === null) {
                throw new \CException('Коллекция не найдена');
            }
        }
        return $collection;
    }
} 