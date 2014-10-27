<?php

namespace site\frontend\modules\posts\models;

/**
 * Description of SerializedModel
 *
 * @author Кирилл
 */
abstract class SerializedModel extends \CModel implements \IHToJSON
{

    protected $_owner = null;

    public function unserialize($data)
    {
        $this->setAttributes(\CJSON::decode($data), false);
    }

    public function __construct($data, $owner)
    {
        $this->_owner = $owner;
        $this->unserialize($data);
    }

    public function getOwner()
    {
        return $this->_owner;
    }
    
    public function getPrimaryKey()
    {
        return $this->_owner->primaryKey;
    }

    public function __toString()
    {
        return $this->serialize();
    }

    public function serialize()
    {
        return \CJSON::encode($this->toJSON());
    }

    public function toJSON()
    {
        return $this->attributes;
    }

}

?>
