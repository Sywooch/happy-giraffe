<?php

namespace site\frontend\modules\som\modules\qa\widgets\answers;

use site\frontend\modules\som\modules\qa\models\QaRating;
use site\frontend\modules\som\modules\qa\models\QaCategory;

/**
 * @author Emil Vililyaev
 */
class AnswerHeaderWidget extends \CWidget
{

    /**
     * @var integer
     */
    public $userId;

    /**
     * {@inheritDoc}
     * @see CWidget::init()
     */
    public function init()
    {
        if (is_null($this->userId))
        {
            throw new \Exception('userId must be passed!');
        }
    }

    /**
     * {@inheritDoc}
     * @see CWidget::run()
     */
    public function run()
    {
        $ratingRow = QaRating::model()->byCategory(QaCategory::PEDIATRICIAN_ID)->byUser($this->userId)->find();

        if (is_null($ratingRow))
        {
            return;
        }

        $flowerCount = $this->_getFlowersCount($ratingRow->votes_count);

        $this->render('answer_header', ['rating' => $ratingRow, 'flowerCount' => $flowerCount]);
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
                return 0;
        }
    }

}