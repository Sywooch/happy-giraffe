<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 17/09/14
 * Time: 10:17
 */

namespace site\frontend\modules\photo\models\collections;
use site\frontend\modules\photo\models\PhotoAttach;
use site\frontend\modules\photo\models\PhotoCollection;

abstract class PhotoCollectionAbstract extends PhotoCollection
{
    public function attachPhotos($ids)
    {
        $collections = array_merge(array($this), $this->getRelatedCollections());
        $success = true;
        foreach ($ids as $photoId) {
            foreach ($collections as $collection) {
                $success = $success && $collection->attachPhoto($photoId);
            }
        }
        return $success;
    }

    public function sortAttaches($attachesIds)
    {
        foreach ($attachesIds as $i => $attachId) {
            PhotoAttach::model()->updateByPk($attachId, array('position' => $i));
        }
    }

    public function moveAttaches($destinationCollection, $attaches)
    {
        $newPosition = $this->getMaxPosition() + 1;

        $criteria = new \CDbCriteria(array(
            'scopes' => array(
                'collection' => $this->id,
            ),
        ));
        $criteria->addInCondition('id', $attaches);

        return PhotoAttach::model()->updateAll(array(
            'collection_id' => $destinationCollection->id,
            'position' => $newPosition,
        ), $criteria) == count($attaches);
    }

    public function getRelatedCollections()
    {
        return array();
    }

    abstract public function getCollectionLabel();
    abstract public function getCollectionTitle();
    abstract public function getCollectionDescription();
} 