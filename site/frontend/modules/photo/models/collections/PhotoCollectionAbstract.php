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
                $attach = new PhotoAttach();
                $attach->photo_id = $photoId;
                $attach->collection_id = $collection->id;
                $attach->save();
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