<?php

namespace site\frontend\modules\photo\components;

/**
 * Поведение для AR моделей, имеющих коллекцию
 *
 * Создает relation для связи с коллекцией
 * @author Кирилл
 * @property \CActiveRecord $owner Description
 */
class ActivePhotoCollectionBehavior extends PhotoCollectionBehavior
{

    /**
     * Добавляет отношение "photoCollections".
     *
     * @param \CActiveRecord $owner
     */
    public function attach($owner)
    {
        $owner->getMetaData()->addRelation('photoCollections', array(
            \CActiveRecord::HAS_MANY,
            'site\frontend\modules\photo\models\PhotoCollection',
            'entity_id',
            'on' => 'entity = :entity',
            'params' => array(':entity' => $owner->getEntityName()),
            'index' => 'key',
        ));
        parent::attach($owner);
    }

    /**
     * Возвращает определенную ключем коллекции сущности.
     *
     * @param string $key признак коллекции
     * @param boolean $create создавать ли коллекцию в случае отсутствия
     * @return null|\site\frontend\modules\photo\models\PhotoCollection
     */
    public function getPhotoCollection($key = 'default', $create = true)
    {
        // сначала ищем в только что созданных - это быстрее всего
        if (isset(self::$_createdDuringRequest[$this->getEntityName()][$this->owner->id][$key])) {
            return self::$_createdDuringRequest[$this->getEntityName()][$this->owner->id][$key];
        }

        // потом в релейшнах
        $refresh = $this->owner->hasRelated('photoCollections') && !isset($this->owner->photoCollections[$key]); // рефрешим только если релейшн уже был загружен, но нужного ключа там нет
        $collections = $this->owner->getRelated('photoCollections', $refresh);
        if (isset($collections[$key])) {
            return $collections[$key];
        }

        if (!$create) {
            return null;
        } else {
            $collection = $this->createCollection($key);
            if ($collection !== null) {
                self::$_createdDuringRequest[$this->getEntityName()][$this->owner->id][$key] = $collection;
            }
            return $collection;
        }
    }

}
