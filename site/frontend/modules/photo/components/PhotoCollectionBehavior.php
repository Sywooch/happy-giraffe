<?php
/**
 * Поведение для моделей, имеющих коллекцию
 *
 * Создает relation для связи с коллекцией
 */

namespace site\frontend\modules\photo\components;
use site\frontend\modules\photo\models\PhotoCollection;

class PhotoCollectionBehavior extends \CActiveRecordBehavior
{
    public $photoCollection;

    /**
     * @param \HActiveRecord $owner
     */
    public function attach($owner)
    {
        $owner->getMetaData()->addRelation('photoCollections', array(
            \CActiveRecord::HAS_MANY,
            'site\frontend\modules\photo\models\PhotoCollection',
            'entity_id',
            'condition' => 'entity = :entity',
            'params' => array(':entity' => $owner->getEntityName()),
            'index' => 'key',
        ));
        parent::attach($owner);
    }

    public function afterSave($event)
    {
        if ($this->owner->isNewRecord) {
            foreach (PhotoCollection::$config[$this->owner->getEntityName()] as $key => $class) {
                $this->createCollection($key);
            }
        }
    }

    public function getPhotoCollection($key = 'default')
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
} 