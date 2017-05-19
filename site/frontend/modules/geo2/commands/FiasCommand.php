<?php
/**
 * @author Никита
 * @date 16/03/17
 */

namespace site\frontend\modules\geo2\commands;


use site\frontend\modules\geo2\components\fias\handler\MySQLHandler;
use site\frontend\modules\geo2\components\fias\Manager;
use site\frontend\modules\geo2\components\fias\output\DumpOutput;
use site\frontend\modules\geo2\components\fias\update\UpdateManager;
use site\frontend\modules\geo2\components\fias\update\VersionManager;
use site\frontend\modules\geo2\Geo2Module;

class FiasCommand extends \CConsoleCommand
{
    public function actionInit($output, $dataDestination = null)
    {
        $handler = new MySQLHandler(Geo2Module::$fias['prefix']);
        $output = new DumpOutput($output);
        $fiasManager = new Manager($handler, $output, $dataDestination);
        $fiasManager->import();
    }

    public function actionUpdate($version = null)
    {
        $updateManager = new UpdateManager();
        echo sprintf('Текущая версия: %s', $updateManager->versionManager->getCurrentVersion()) . PHP_EOL;
        $updateManager->update($version);
        echo sprintf('%d записей создано, %d обновлено, %d удалено', $updateManager->created, $updateManager->updated, $updateManager->deleted) . PHP_EOL;
    }
    
    public function actionSetCurrentVerstion($version = false)
    {
        (new VersionManager())->setCurrentVersion($version);
    }

    public function actionGetCurrentVersion()
    {
        echo (new VersionManager())->getCurrentVersion() . "\n";
    }
}