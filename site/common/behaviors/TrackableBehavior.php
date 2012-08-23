<?php
/**
 * Author: choo
 * Date: 24.07.2012
 */
class TrackableBehavior extends CActiveRecordBehavior
{
    public $attributes = true;

    private $_old_attributes;

    public function attach($owner)
    {
        parent::attach($owner);

        $owner->attachEventHandler('onAfterFind', array($this, 'setOldAttributes'));
    }

    public function detach($owner)
    {
        parent::detach($owner);

        $owner->detachEventHandler('onAfterFind', array($this, 'setOldAttributes'));
    }

    public function setOldAttributes()
    {
        $this->_old_attributes = $this->owner->getAttributes($this->attributes);
    }

    public function getOldAttribute($attribute)
    {
        return $this->_old_attributes[$attribute];
    }

    public function isChanged($attribute)
    {
        return $this->owner->getAttribute($attribute) != $this->_old_attributes[$attribute];
    }
}
