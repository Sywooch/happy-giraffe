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
        foreach ($ids as $photoId) {
            foreach ($collections as $collection) {
                $collection->attachPhoto($photoId);
            }
        }
    }

    public function getRelatedCollections()
    {
        return array();
    }

    abstract public function getCollectionLabel();
    abstract public function getCollectionTitle();
    abstract public function getCollectionDescription();
} 