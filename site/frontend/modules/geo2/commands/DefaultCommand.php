<?php

namespace site\frontend\modules\geo2\commands;
use site\frontend\modules\geo2\components\fias\handler\MySQLHandler;
use site\frontend\modules\geo2\components\fias\Manager;
use site\frontend\modules\geo2\components\fias\output\DumpOutput;

/**
 * @author Никита
 * @date 21/02/17
 */
class DefaultCommand extends \CConsoleCommand
{
    public function actionIndex($schema, $data, $output)
    {
        $handler = new MySQLHandler('FIAS__');
        $output = new DumpOutput($output);
        $fiasManager = new Manager($schema, $data, $handler, $output);
        $fiasManager->import();
    }
}