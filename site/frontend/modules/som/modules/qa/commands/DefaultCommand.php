<?php
/**
 * @author Никита
 * @date 11/11/15
 */

namespace site\frontend\modules\som\modules\qa\commands;


use site\frontend\modules\som\modules\qa\components\BulkDataGenerator;
use site\frontend\modules\som\modules\qa\components\QaUsersRatingManager;
use site\frontend\modules\som\modules\qa\components\QuestionsRatingManager;
use site\frontend\modules\som\modules\qa\components\VotesManager;
use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaQuestion;

class DefaultCommand extends \CConsoleCommand
{
    public function actionRoutine()
    {
        QuestionsRatingManager::updateAll();
        QaUsersRatingManager::run();
    }

    public function actionFillDb()
    {
        BulkDataGenerator::run();
    }

    public function actionTest()
    {
        VotesManager::setIsBest(10064);
    }
}