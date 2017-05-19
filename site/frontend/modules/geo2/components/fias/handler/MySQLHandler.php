<?php

namespace site\frontend\modules\geo2\components\fias\handler;
use site\frontend\modules\geo2\components\fias\Field;

/**
 * @author Никита
 * @date 22/02/17
 */
class MySQLHandler implements IHandler
{
    public $prefix;
    
    public function __construct($prefix)
    {
        $this->prefix = $prefix;
    }

    public function insertRow($tableName, array $fields)
    {
        $queryTemplate = "INSERT INTO `%s` (`%s`) VALUES ('%s');" . PHP_EOL;
        return sprintf($queryTemplate, $this->prefix . $tableName, implode("`, `", array_keys($fields)), implode("', '", $fields));
    }
    
    public function createTable($tableName, $tableComment, array $fields)
    {
        $_fields = [];

        foreach ($fields as $i => $field) {
            $query = sprintf('`%s`', $field->name);
            $query .= ' ';

            switch ($field->type) {
                case Field::TYPE_INTEGER:
                    $query .= sprintf('int(%u) unsigned', $field->length);
                    break;
                case Field::TYPE_STRING:
                    $query .= sprintf('varchar(%u)', $field->length);
                    break;
                case Field::TYPE_DATE:
                    $query .= 'date';
                    break;
            }

            $query .= ' ';
            if ($field->required) {
                $query .= 'not null';
            } else {
                $query .= 'null default null';
            }
            $query .= ' ';
            $query .= sprintf("comment '%s'", $field->comment);
            $_fields[] = $query;
        }

        return sprintf("CREATE TABLE `%s` (%s) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='%s';", $this->prefix . $tableName, implode(', ' . PHP_EOL, $_fields), $tableComment);
    }
}