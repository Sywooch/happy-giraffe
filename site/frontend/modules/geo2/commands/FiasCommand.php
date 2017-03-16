<?php
/**
 * @author Никита
 * @date 16/03/17
 */

namespace site\frontend\modules\geo2\commands;


use site\frontend\modules\geo2\components\fias\update\UpdateManager;

class FiasCommand extends \CConsoleCommand
{
    public function actionUpdate()
    {
        (new UpdateManager())->update();
    }
}