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

    public static function sort($attachesIds)
    {
        $success = true;
        foreach ($attachesIds as $i => $attachId) {
            $success = $success && PhotoAttach::model()->updateByPk($attachId, array('position' => $i));
        }
        return $success;
    }

    public function getRelatedCollections()
    {
        return array();
    }

    abstract public function getCollectionLabel();
    abstract public function getCollectionTitle();
    abstract public function getCollectionDescription();
} 