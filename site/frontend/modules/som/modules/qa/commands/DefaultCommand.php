<?php
/**
 * @author Никита
 * @date 11/11/15
 */

namespace site\frontend\modules\som\modules\qa\commands;


use site\frontend\modules\som\modules\qa\components\BulkDataGenerator;
use site\frontend\modules\som\modules\qa\components\QuestionsRatingManager;
use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaQuestion;

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

    public function actionTest()
    {
        $answer = QaAnswer::model()->findByPk(103);
        $answer->softDelete();
    }
}