<?php

namespace site\frontend\modules\comments\modules\contest\components;

use site\frontend\modules\comments\modules\contest\models\CommentatorsContest;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant;

class ContestManager
{
    const COMMENTS_CONTEST_NAME = 'Конкурс ';
    private static $monthes = array(
        '01' => 'Января',
        '02' => 'Февраля',
        '03' => 'Марта',
        '04' => 'Апреля',
        '05' => 'Мая',
        '06' => 'Июня',
        '07' => 'Июля',
        '08' => 'Августа',
        '09' => 'Сентября',
        '10' => 'Октября',
        '11' => 'Ноября',
        '12' => 'Декабря',
    );

    /**
     * Find or create contest for current month.
     *
     * @return CommentatorsContest|bool
     */
    public static function getCurrentActive()
    {
        if (!($current = CommentatorsContest::model()->currentActive()->find())) {
            $current = new CommentatorsContest();
            $current->name = self::COMMENTS_CONTEST_NAME . self::$monthes[date('m')];
            $current->month = date('mY');

            if (!$current->save()) {
                return false;
            }
        }

        return $current;
    }
}