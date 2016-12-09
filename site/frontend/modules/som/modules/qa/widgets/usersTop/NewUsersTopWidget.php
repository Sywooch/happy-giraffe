<?php

namespace site\frontend\modules\som\modules\qa\widgets\usersTop;

use site\frontend\components\TopWidgetAbstract;
use site\frontend\modules\som\modules\qa\models\QaRating;
use site\frontend\modules\som\modules\qa\models\QaCategory;

/**
 * @author Emil Vililyaev
 */
class NewUsersTopWidget extends UsersTopWidget
{

    /**
     * {@inheritDoc}
     * @see \site\frontend\modules\som\modules\qa\widgets\usersTop\UsersTopWidget::init()
     */
    public function init()
    {
        $this->setViewName($this->viewFileName);
    }

    /**
     * {@inheritDoc}
     * @see \site\frontend\components\TopWidgetAbstract::getData()
     */
//     public function getData()
//     {
//         parent::getData();
//     }

    //-----------------------------------------------------------------------------------------------------------

    /**
     * {@inheritDoc}
     * @see \site\frontend\components\TopWidgetAbstract::_process()
     */
    protected function _process()
    {
        $arrRating = QaRating::model()->byCategory(QaCategory::PEDIATRICIAN_ID)->findAll();

        foreach ($arrRating as $rating)
        {
            $this->scores[$rating->user_id] = $rating->total_count;
        }

        $this->_setTitle();

        arsort($this->scores);
    }

}