<?php
/**
 * @author Никита
 * @date 11/11/15
 */

namespace site\frontend\modules\som\modules\qa\commands;


use site\frontend\modules\som\modules\qa\components\BulkDataGenerator;
use site\frontend\modules\som\modules\qa\components\QuestionsRatingManager;

class DefaultCommand extends \CConsoleCommand
{
    public function actionRoutine()
    {
        QuestionsRatingManager::updateAll();
    }

    public function actionFillDb()
    {
        BulkDataGenerator::run();
    }
}