<?php

namespace site\frontend\modules\geo2\components\fias\handler;

/**
 * @author Никита
 * @date 22/02/17
 */
interface IHandler
{
    public function insertRow($table, array $fields);
    public function createTable($tableName, $tableComment, array $fields);
}