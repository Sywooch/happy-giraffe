<?php
/**
 * @author Никита
 * @date 24/02/15
 */

namespace site\frontend\modules\comments\modules\contest\commands;


use site\frontend\modules\comments\modules\contest\models\CommentatorsContest;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContestRating;

class DefaultCommand extends \CConsoleCommand
{
    public function actionUpdatePositions()
    {
        $contest = CommentatorsContest::model()->active()->find();
        if ($contest !== null) {
            $contest->updatePositions();
        }
    }

    public function actionTest()
    {
        $ratings = CommentatorsContestRating::model()->findAll();
        foreach ($ratings as $r) {
            echo implode(',', $r->attributes) . "\n";
        }
    }

    public function actionAddFixtures()
    {
        $sql = <<<SQL
SELECT id
FROM users
LIMIT 10000;
SQL;
        $insert = <<<SQL
INSERT INTO commentators__contests_participants (userId, contestId, score, dtimeRegister)
VALUES (:userId, 1, :score, :dtimeRegister)
SQL;
        $ids = \Yii::app()->db->createCommand($sql)->queryColumn();
        foreach ($ids as $id) {
            \Yii::app()->db->createCommand($insert)->execute(array(
                ':userId' => $id,
                ':score' => mt_rand(1, 10000),
                ':dtimeRegister' => time(),
            ));
        }
    }
}