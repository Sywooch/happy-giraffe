<?php

namespace site\frontend\modules\posts\modules\contractubex\widgets\sidebarWidget;
use site\frontend\modules\posts\modules\contractubex\components\ContractubexHelper;
use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\modules\contractubex\widgets\ChosenPostsWidget;

/**
 * @author Никита
 * @date 03/12/15
 */

class SidebarWidget extends ChosenPostsWidget
{
    public $exclude = array();

    protected function getCriteria()
    {
        $criteria = parent::getCriteria();
        $criteria->addNotInCondition('t.id', $this->exclude);
        return $criteria;
    }
}