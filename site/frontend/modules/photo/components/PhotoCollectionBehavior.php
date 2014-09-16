<?php
/**
 * Поведение для моделей, имеющих коллекцию
 *
 * Создает relation для связи с коллекцией
 */

namespace site\frontend\modules\photo\components;

use site\frontend\modules\photo\models\PhotoCollection;

abstract class PhotoCollectionBehavior extends \CActiveRecordBehavior
{
    /**
     * @param \HActiveRecord $owner
     */
    public function attach($owner)
    {
        $class = \CActiveRecord::HAS_MANY;
        $relationName = 'photoCollections';
        $owner->getMetaData()->relations[$relationName] =
            new $class($relationName,
                'site\frontend\modules\photo\models\PhotoCollection',
                'entity_id',
                array('condition' => 'entity = :entity', 'params' => array(':entity' => $owner->getEntityName()), 'index' => 'key')
            );
        parent::attach($owner);
    }

    public function afterSave($event)
    {
        if ($this->owner->isNewRecord) {
            foreach ($this->getKeys() as $key) {
                $this->createCollection($key);
            }
        }
    }

    public function getRelatedCollection($key)
    {
        if (isset($this->owner->photoCollections[$key])) {
            return $this->owner->photoCollections[$key];
        } else {
            return $this->createCollection($key);
        }
    }

    protected function createCollection($key)
    {
        $collection = new PhotoCollection();
        $collection->entity_id = $this->owner->id;
        $collection->entity = $this->owner->getEntityName();
        $collection->key = $key;
        $collection->save();
        return $collection;
    }

    abstract public function getKeys();
} 