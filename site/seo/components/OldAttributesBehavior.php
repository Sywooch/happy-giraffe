<?php
/**
 * Author: alexk984
 * Date: 23.05.12
 */

class OldAttributesBehavior extends CActiveRecordBehavior
{
    private $_oldattributes = array();

    public function afterFind($event)
    {
        $this->setOldAttributes($this->Owner->getAttributes());
    }

    public function getOldAttributes()
    {
        return $this->_oldattributes;
    }

    public function getOldAttribute($attribute)
    {
        return $this->_oldattributes[$attribute];
    }

    public function setOldAttributes($value)
    {
        $this->_oldattributes=$value;
    }
}