<?php

namespace site\frontend\modules\iframe\components;

use site\frontend\modules\iframe\models\QaRating;
use site\frontend\modules\iframe\models\QaCategory;
use site\frontend\modules\iframe\models\QaQuestion;

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
            return ['rating' => QaRating::model()->toJSON(), 'flowerCount' => 0,'questions' => $this->_getQuestionCount($userId)];
        }

        $flowerCount = $this->_getFlowersCount($ratingRow->votes_count);

        return ['rating' => $ratingRow->toJSON(), 'flowerCount' => $flowerCount,'questions' => $this->_getQuestionCount($userId)];
    }

    private function _getQuestionCount($userId)
    {
        $model = clone QaQuestion::model();
        return $model->user($userId)->count();
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