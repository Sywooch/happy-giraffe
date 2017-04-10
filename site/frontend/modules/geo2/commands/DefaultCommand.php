<?php

namespace site\frontend\modules\geo2\commands;
use GeoIp2\Database\Reader;
use site\frontend\modules\geo2\components\combined\CombinedManager;
use site\frontend\modules\geo2\components\combined\modifier\FiasModifier;
use site\frontend\modules\geo2\components\fias\handler\MySQLHandler;
use site\frontend\modules\geo2\components\fias\Manager;
use site\frontend\modules\geo2\components\fias\output\DumpOutput;
use site\frontend\modules\geo2\components\fias\update\DeltaGetter;
use site\frontend\modules\geo2\components\fias\update\VersionManager;
use site\frontend\modules\geo2\components\fias\update\UpdateManager;
use site\frontend\modules\geo2\components\LocationRecognizer;
use site\frontend\modules\geo2\components\MigrationManager;
use site\frontend\modules\geo2\Geo2Module;

/**
 * @author Никита
 * @date 21/02/17
 */
class DefaultCommand extends \CConsoleCommand
{
    public function actionInit()
    {
        (new CombinedManager())->init();
    }
    
    public function actionMigrate($dryRun = true)
    {
        (new MigrationManager())->run($dryRun);
    }
}