<?php

namespace site\frontend\modules\iframe\widgets\answers;

use site\frontend\modules\iframe\components\QaRatingManager;

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
        $arrCounters = (new QaRatingManager)->getViewCounters($this->userId);

        if (is_null($arrCounters))
        {
            return;
        }

        $this->render('answer_header', $arrCounters);
    }

}