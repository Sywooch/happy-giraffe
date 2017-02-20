<?php

namespace site\frontend\modules\som\modules\qa\commands;

use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaAnswerVote;
use site\frontend\modules\som\modules\qa\models\QaRating;
use site\frontend\modules\som\modules\qa\models\QaRatingHistory;

class FixRatingByHistoryCommand extends \CConsoleCommand
{
    public function actionIndex()
    {
        $iterator = new \CDataProviderIterator(new \CActiveDataProvider(QaRatingHistory::model(), [
            'criteria' => [
                'select' => '*, count(*) as points',
                'group' => 'user_id, category_id'
            ],
        ]));

        foreach ($iterator as $history) {
            $answersCount = (int) QaRatingHistory::model()
                ->byCategory($history->category_id)
                ->byUser($history->user_id)
                ->byModel((new \ReflectionClass(QaAnswer::model()))->getShortName())
                ->count();

            $votesCount = (int) QaRatingHistory::model()
                ->byCategory($history->category_id)
                ->byUser($history->user_id)
                ->byModel((new \ReflectionClass(QaAnswerVote::model()))->getShortName())
                ->count();

            $cachedRating = QaRating::model()
                ->byCategory($history->category_id)
                ->byUser($history->user_id)
                ->find();

            if (!$cachedRating) {
                echo "Cached Rating Not Found, Creating New\n";
                $cachedRating = new QaRating();

                $cachedRating->user_id = $history->user_id;
                $cachedRating->category_id = $history->category_id;

                $cachedRating->answers_count = $answersCount;
                $cachedRating->votes_count = $votesCount;
                $cachedRating->total_count = $answersCount + $votesCount;

                if (!$cachedRating->save()) {
                    $this->error($cachedRating);
                }

                continue;
            }

            $isChanged = false;

            if ($cachedRating->answers_count != $answersCount) {
                $cachedRating->answers_count = $answersCount;
                $isChanged = true;
            }

            if ($cachedRating->votes_count != $votesCount) {
                $cachedRating->votes_count = $votesCount;
                $isChanged = true;
            }

            if ($isChanged) {
                echo "Cached rating changing...\n";
                echo "Cached rating old total count: {$cachedRating->total_count}, user_id: {$cachedRating->user_id}\n";
                $cachedRating->total_count = $answersCount + $votesCount;
                echo "Cached rating new total count: {$cachedRating->total_count}, user_id: {$cachedRating->user_id}\n";

                if (!$cachedRating->save()) {
                    $this->error($cachedRating);
                }
            }
        }

        $cachedRatingIterator = new \CDataProviderIterator(new \CActiveDataProvider(QaRating::model()));

        foreach ($cachedRatingIterator as $rating) {
            if ($rating->answers_count == 0 && $rating->votes_count == 0 && $rating->total_count == 0) {
                continue;
            }

            $history = QaRatingHistory::model()
                ->byCategory($rating->category_id)
                ->byUser($rating->user_id)
                ->findAll();

            if (!$history || count($history) == 0) {
                echo "Rating without history\n";
                echo "Deleting...\n";

                if (!$rating->delete()) {
                    $this->error($rating);
                }
            }
        }
    }

    private function error($model)
    {
        $messages = implode('\n', $model->getErrors());
        echo "Failed to save model cause:\n{$messages}";
    }
}