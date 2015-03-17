<?php
namespace site\frontend\modules\analytics\commands;
use site\frontend\modules\analytics\components\MigrateManager;
use site\frontend\modules\analytics\components\VisitsManager;
use site\frontend\modules\analytics\models\PageView;
use site\frontend\modules\posts\models\Content;

/**
 * @author Никита
 * @date 26/01/15
 */

class ViewsCommand extends \CConsoleCommand
{
    public function actionFlushVisits()
    {
        echo \Yii::app()->statePersister->stateFile;
        //\Yii::app()->getModule('analytics')->visitsManager->flushBuffer();
    }
} 