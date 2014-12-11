<?php
/**
 * @author Никита
 * @date 27/10/14
 */

namespace site\frontend\components\api;


class ApiRelation extends \CComponent
{
    public $name;
    public $className;
    public $foreignKey;
    public $params;

    public function __construct($name, $className, $foreignKey, $options = array())
    {
        $this->name = $name;
        $this->className = $className;
        $this->foreignKey = $foreignKey;
        foreach ($options as $name => $value) {
            $this->$name = $value;
        }
    }
}