<?php

namespace site\frontend\modules\comments\modules\contest\components;

use site\frontend\modules\comments\modules\contest\models\CommentatorsContest;

class ContestManager
{
    const COMMENTS_CONTEST_NAME = 'Конкурс Комментаторов';

    /**
     * Find or create contest for current month.
     *
     * @return CommentatorsContest|bool
     */
    public static function getCurrentActive()
    {
        if (!($current = CommentatorsContest::model()->currentActive()->find())) {
            $current = new CommentatorsContest();
            $current->name = self::COMMENTS_CONTEST_NAME;
            $current->month = date('mY');

            if (!$current->save()) {
                return false;
            }
        }

        return $current;
    }
}