<?php

namespace site\frontend\modules\comments\modules\contest\components;

use site\frontend\modules\comments\modules\contest\models\CommentatorsContest;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant;

class ContestManager
{
    const COMMENTS_CONTEST_NAME = 'Комментатор ';
    private static $monthes = array(
        '01' => 'января',
        '02' => 'февраля',
        '03' => 'марта',
        '04' => 'апреля',
        '05' => 'мая',
        '06' => 'июня',
        '07' => 'июля',
        '08' => 'августа',
        '09' => 'сентября',
        '10' => 'октября',
        '11' => 'ноября',
        '12' => 'декабря',
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

        if (!\Yii::app()->user->isGuest) {
            $current->addParticipant(\Yii::app()->user->id);
        }

        return $current;
    }
}