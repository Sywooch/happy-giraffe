<?php

namespace site\frontend\modules\som\modules\qa\components;

use site\frontend\modules\som\modules\qa\models\QaRating;
use site\frontend\modules\som\modules\qa\models\QaCategory;

/**
 * @author Emil Vililyaev
 */
class QaRatingManager
{

    /**
     * @return NULL|array
     */
    public function getViewCounters($userId)
    {
        $ratingRow = QaRating::model()->byCategory(QaCategory::PEDIATRICIAN_ID)->byUser($userId)->find();

        if (is_null($ratingRow))
        {
            return ['rating' => QaRating::model()->toJSON(), 'flowerCount' => 0];
        }

        $flowerCount = $this->_getFlowersCount($ratingRow->votes_count);

        return ['rating' => $ratingRow->toJSON(), 'flowerCount' => $flowerCount];
    }

    /**
     * @param integer $count
     * @return integer
     */
    private function _getFlowersCount($count)
    {
        switch (TRUE)
        {
            case $count > 500 :
                return 5;
            case $count > 100 :
                return 3;
            case $count > 9 :
                return 1;
            default:
                return 1;
        }
    }

}