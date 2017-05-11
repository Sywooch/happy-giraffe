<?php
/**
 * @author Никита
 * @date 27/02/17
 */

namespace site\frontend\modules\geo2\components\fias;


class Table
{
    public $comment;
    public $fields;

    public function __construct($comment, $fields)
    {
        $this->comment = $comment;
        $this->fields = $fields;
    }

    public function getColumnNames()
    {
        return array_map(function(Field $field) {
            return $field->name;
        }, $this->fields);
    }
}