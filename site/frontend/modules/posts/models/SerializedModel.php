<?php

namespace site\frontend\modules\posts\models;

/**
 * Description of SerializedModel
 *
 * @author Кирилл
 */
abstract class SerializedModel extends \CModel implements \IHToJSON
{

    public function unserialize($data)
    {
        $this->setAttributes(\CJSON::decode($data), false);
    }

    public function __construct($data)
    {
        $this - unserialize($data);
    }
    
    public function __toString()
    {
        return '';
    }

}

?>
