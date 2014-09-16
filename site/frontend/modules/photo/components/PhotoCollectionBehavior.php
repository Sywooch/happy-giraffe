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
                $collection = new PhotoCollection();
                $collection->entity_id = $this->owner->id;
                $collection->entity = $this->owner->getEntityName();
                $collection->key = $key;
                $collection->save();
            }
        }
    }

    public function getRelatedCollections()
    {
        return array();
    }

    abstract public function getKeys();
} 