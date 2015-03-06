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

    public function actionRegisterCommentators()
    {
        $dp = new \CActiveDataProvider('Comment', array(
            'criteria' => array(
                'order' => 'id ASC',
                'join' => 'LEFT OUTER JOIN commentators__contests_comments cc ON t.id = cc.commentId',
                'condition' => 'created > "2015-03-03 14:45:58" AND cc.commentId IS NULL',
            ),
        ));

        echo $dp->totalItemCount;
    }

    public function actionAddFixtures()
    {
        \Yii::app()->db->createCommand("INSERT INTO `commentators__contests` (`id`, `startDate`, `endDate`)
VALUES
	(1, '2015-03-02', '2015-03-16');
")->execute();

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

        $sql = <<<SQL
SELECT id FROM commentators__contests_participants;
SQL;
        $participantsIds = \Yii::app()->db->createCommand($sql)->queryColumn();

        $sql = <<<SQL
SELECT id FROM comments  WHERE entity = 'CommunityContent' LIMIT 10000
SQL;
        $commentsIds = \Yii::app()->db->createCommand($sql)->queryColumn();

        $insert = <<<SQL
INSERT INTO commentators__contests_comments (participantId, commentId, counts)
VALUES (:participantId, :commentId, 1)
SQL;
        foreach ($participantsIds as $i => $p) {
            \Yii::app()->db->createCommand($insert)->execute(array(
                ':participantId' => $p,
                ':commentId' => $commentsIds[$i],
            ));
        }
    }
}