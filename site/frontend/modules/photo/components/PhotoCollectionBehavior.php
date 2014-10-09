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
    public $attributeCollections = array();

    /**
     * Добавляет отношение "photoCollections".
     *
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


    /**
     * При создании сущности, создает для нее все необходимые коллекции.
     *
     * @param \CModelEvent $event
     */
    public function afterSave($event)
    {
        if ($this->owner->isNewRecord) {
            foreach (PhotoCollection::$config[$this->owner->getEntityName()] as $key => $class) {
                $this->createCollection($key);
            }
        }

        foreach ($this->textCollections as $attribute) {
            $photoIds = $this->getPhotoIdsByString($this->owner->$attribute);
            $collection = $this->getPhotoCollection($this->getAttributeCollectionKey($attribute));
            $collection->attachPhotos($photoIds);
        }
    }

    /**
     * Возвращает определенную ключем коллекции сущности.
     *
     * @param string $key признак коллекции
     * @return \site\frontend\modules\photo\models\PhotoCollection
     */
    public function getPhotoCollection($key = 'default')
    {
        if (isset($this->owner->photoCollections[$key])) {
            return $this->owner->photoCollections[$key];
        } else {
            return $this->createCollection($key);
        }
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
     * @return \site\frontend\modules\photo\models\PhotoCollection
     */
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