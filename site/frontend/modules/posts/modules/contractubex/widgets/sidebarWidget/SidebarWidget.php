<?php

namespace site\frontend\modules\posts\modules\contractubex\widgets\sidebarWidget;
use site\frontend\modules\posts\modules\contractubex\components\ContractubexHelper;
use site\frontend\modules\posts\models\Content;

/**
 * @author Никита
 * @date 03/12/15
 */

class SidebarWidget extends \CWidget
{
    const LIMIT = 5;

    public function run()
    {
        $criteria = ContractubexHelper::getChosenPostsCriteria();
        $criteria->limit = self::LIMIT;
        $models = Content::model()->findAll($criteria);
        if (count($models) > 0) {
            $this->render('view', compact('models'));
        }
    }
}