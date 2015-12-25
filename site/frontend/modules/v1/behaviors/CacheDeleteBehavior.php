<?php

namespace site\frontend\modules\v1\behaviors;

use site\frontend\modules\v1\components\V1ApiController;

/**
 * Checks key collection in cache and delete keys which contains owner model.
 */
class CacheDeleteBehavior extends \CActiveRecordBehavior
{
    public function afterSave($event)
    {
        parent::afterSave($event);

        $this->handleCollection();
    }

    public function afterDelete($event)
    {
        parent::afterDelete($event);

        $this->handleCollection();
    }

    private function handleCollection()
    {
        $collection = \Yii::app()->cache->get(V1ApiController::KEYS_COLLECTION);

        if (!$collection) {
            return;
        }
        \Yii::log(get_class($this->owner), 'info', 'CacheDeleteBehavior');

        $owner = get_class($this->owner);
        $total = count($collection);

        \Yii::log($total, 'info', 'CacheDeleteBehavior');

        $collection = array_values($collection);

        //$deleteKeys = array();
        for ($i = 0; $i < $total; $i++) {
            if (strstr(json_decode($collection[$i])->model, $owner)) {
                \Yii::app()->cache->delete($collection[$i]);
                //array_push($deleteKeys, $collection[$i]);
                unset($collection[$i]);
            }
        }

        \Yii::log(print_r($collection, true), 'info', 'CacheDeleteBehavior');

        \Yii::app()->cache->set(V1ApiController::KEYS_COLLECTION, $collection, V1ApiController::CACHE_COLLECTION_EXPIRE);
    }
}