<?php

/**
 * Поведение для моделей, имеющих коллекцию
 *
 * Создает relation для связи с коллекцией
 * @property \CModel $owner Description
 */

namespace site\frontend\modules\photo\components;

use site\frontend\modules\photo\models\PhotoCollection;

class PhotoCollectionBehavior extends \CBehavior
{

    public $attributeCollections = array();
    protected static $_createdDuringRequest = array();
    protected $_collections = array();
    public $entity = false;
    public $entityId = false;

    public function events()
    {
        return array_merge(parent::events(), array(
            'onAfterSave' => 'afterSave',
        ));
    }

    public function getEntityId()
    {
        if ($this->entityId) {
            if (is_array($this->entityId)) {
                return call_user_func($this->entityId, $this->owner);
            } else {
                return $this->owner->{$this->entityId};
            }
        } else {
            return $this->owner->id;
        }
    }

    public function getEntityName()
    {
        if ($this->entity) {
            if (is_array($this->entity)) {
                return call_user_func($this->entity, $this->owner);
            } else {
                return $this->owner->{$this->entity};
            }
        } else {
            return get_class($this->owner);
        }
    }

    /**
     * При создании сущности, создает для нее все необходимые коллекции.
     *
     * @param \CModelEvent $event
     */
    public function afterSave($event)
    {
        foreach ($this->attributeCollections as $attribute) {
            $photoIds = $this->getPhotoIdsByString($this->owner->$attribute);
            $collection = $this->getPhotoCollection($this->getAttributeCollectionKey($attribute));
            $collection->attachPhotos($photoIds, true);
        }
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
        if (isset(self::$_createdDuringRequest[$this->getEntityName()][$this->getEntityId()][$key])) {
            return self::$_createdDuringRequest[$this->getEntityName()][$this->getEntityId()][$key];
        }

        $collections = $this->getCollections();

        if (isset($collections[$key])) {
            return $collections[$key];
        }

        if (!$create) {
            return null;
        } else {
            $collection = $this->createCollection($key);
            if ($collection !== null) {
                self::$_createdDuringRequest[$this->getEntityName()][$this->getEntityId()][$key] = $collection;
            }
            return $collection;
        }
    }

    protected function getCollections()
    {
        return PhotoCollection::model()->findAll(array(
            'condition' => 'entity_id = :id AND entity = :entity',
            'index' => 'key',
            'params' => array(
                ':entity' => $this->getEntityName(),
                ':id' => $this->getEntityId(),
            )
        ));
    }

    public function getAttributePhotoCollection($attribute)
    {
        return $this->getPhotoCollection($this->getAttributeCollectionKey($attribute));
    }

    protected function getAttributeCollectionKey($attribute)
    {
        return $attribute . 'AttributeCollection';
    }

    protected function getPhotoIdsByString($string)
    {
        include_once \Yii::getPathOfAlias('site.frontend.vendor.simplehtmldom_1_5') . DIRECTORY_SEPARATOR . 'simple_html_dom.php';

        $result = array();
        $doc = str_get_html($string);
        if ($doc === false) {
            return $result;
        }

        foreach ($doc->find('img') as $img) {
            if ($img->{'collection-item'} !== false) {
                $result[] = $img->{'collection-item'};
            }
        }

        return $result;
    }

    /**
     * Создает для данной сущности коллекцию с определенным ключем.
     *
     * @param string $key признак коллекции
     * @return null|\site\frontend\modules\photo\models\PhotoCollection
     */
    protected function createCollection($key)
    {
        $class = PhotoCollection::getClassName($this->owner->getEntityName(), $key);
        $collection = new $class();
        $collection->entity_id = $this->getEntityId();
        $collection->entity = $this->owner->getEntityName();
        $collection->key = $key;
        $success = $collection->save();
        return ($success) ? $collection : null;
    }

}
