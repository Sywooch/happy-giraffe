<?php
/**
 * @author Никита
 * @date 09/03/17
 */

namespace site\frontend\modules\geo2\commands;


use site\frontend\modules\geo2\components\vk\Manager;
use site\frontend\modules\geo2\components\vk\Parser;

class VkCommand extends \CConsoleCommand
{
    public function actionInit()
    {
        (new Manager())->init();
    }

    public function actionUpdate($dryRun = true)
    {
        (new Manager())->update($dryRun);
    }
}