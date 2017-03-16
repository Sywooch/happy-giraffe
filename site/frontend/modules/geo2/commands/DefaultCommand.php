<?php

namespace site\frontend\modules\geo2\commands;
use site\frontend\modules\geo2\components\combined\CombinedManager;
use site\frontend\modules\geo2\components\combined\modifier\FiasModifier;
use site\frontend\modules\geo2\components\fias\handler\MySQLHandler;
use site\frontend\modules\geo2\components\fias\Manager;
use site\frontend\modules\geo2\components\fias\output\DumpOutput;
use site\frontend\modules\geo2\components\fias\update\DeltaGetter;
use site\frontend\modules\geo2\components\fias\update\VersionManager;
use site\frontend\modules\geo2\components\fias\update\UpdateManager;
use site\frontend\modules\geo2\Geo2Module;

/**
 * @author Никита
 * @date 21/02/17
 */
class DefaultCommand extends \CConsoleCommand
{
    public function actionIndex($schema, $data, $output)
    {
        $handler = new MySQLHandler(Geo2Module::$fias['prefix']);
        $output = new DumpOutput($output);
        $fiasManager = new Manager($schema, $data, $handler, $output);
        $fiasManager->import();
    }

    public function actionUpdate()
    {
        $updateManager = new UpdateManager();
        echo sprintf('Текущая версия: %s', $updateManager->versionManager->getCurrentVersion()) . PHP_EOL;
        $updateManager->update();
        echo sprintf('%d записей создано, %d обновлено, %d удалено', $updateManager->created, $updateManager->updated, $updateManager->deleted) . PHP_EOL;
    }
    
    public function actionInit()
    {
        (new CombinedManager())->init();
    }
}