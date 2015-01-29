<?php
namespace site\frontend\modules\analytics\commands;
use site\frontend\modules\analytics\components\VisitsManager;

/**
 * @author Никита
 * @date 26/01/15
 */

class ViewsCommand extends \CConsoleCommand
{
    public function actionIndex()
    {
        $vm = new VisitsManager();
        $vm->inc();
        //$vm->sync('\site\frontend\modules\posts\models\Content');
    }
} 