<?php
/**
 * Промежуточный класс абстрактной фотоколлекции
 *
 * Этот код не в PhotoCollection, потому что если сделать абстрактным родителя, нельзя будет обычным способом создавать
 * новую модель ActiveRecord.
 *
 * @author Никита
 * @date 03/10/14
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

    public function moveAttaches(PhotoCollection $destinationCollection, $attaches)
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

    /**
     * @return \site\frontend\modules\photo\models\PhotoCollection[]
     */
    public function getRelatedCollections()
    {
        return array();
    }

    abstract public function getCollectionLabel();
    abstract public function getCollectionTitle();
    abstract public function getCollectionDescription();
} 