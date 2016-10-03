<?php

namespace site\frontend\modules\comments\modules\contest\commands;

use site\frontend\modules\comments\modules\contest\components\ContestHelper;
use site\frontend\modules\comments\modules\contest\components\ContestManager;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContest;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant;

class ClearScoreCommand extends \CConsoleCommand
{
    public function actionIndex()
    {
        /**
         * @var CommentatorsContest $current
         */
        $current = CommentatorsContest::model()
            ->currentActive()
            ->find();

        /**
         * @var CommentatorsContestParticipant[] $participants
         */
        $participants = CommentatorsContestParticipant::model()
            ->byContest($current->id)
            ->byUsers(ContestHelper::$ids)
            ->findAll();

       $ids = array_map(function($participant) {
           return $participant->id;
       }, $participants);

        CommentatorsContestParticipant::model()->updateByPk($ids, ['score' => 0]);
    }
}