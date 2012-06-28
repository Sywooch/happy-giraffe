<?php
/**
 * Author: choo
 * Date: 09.06.2012
 */
class PurifiedBehavior extends CActiveRecordBehavior
{
    public $attributes = array();
    public $options = array();

    private $_defaultOptions = array(
        'URI.AllowedSchemes' => array(
            'http' => true,
            'https' => true,
        ),
    );

    public function __get($name)
    {
        if (in_array($name, $this->attributes)) {
            $cacheId = $this->getCacheId($name);
            $value = Yii::app()->cache->get($cacheId);
            if ($value === false) {
                $purifier = new CHtmlPurifier;
                $purifier->options = CMap::mergeArray($this->_defaultOptions, $this->options);
                $value = $purifier->purify($this->getOwner()->$name);
                Yii::app()->cache->set($cacheId, $value);
            }
            return $value;
        } else {
            return null;
        }
    }

    public function getCacheId($attributeName)
    {
        return get_class($this->getOwner()) . '_' . $this->getOwner()->primaryKey . '_' . $attributeName;
    }

    public function clearCache()
    {
        foreach ($this->attributes as $a) {
            Yii::app()->cache->delete($this->getCacheId($a));
        }
    }

    public function attach($owner)
    {
        parent::attach($owner);

        $this->attachEventHandler('onAfterSave', 'clearCache');
    }

    public function detach($owner)
    {
        parent::detach($owner);

        $this->detachEventHandler('onAfterSave', 'clearCache');
    }
}
