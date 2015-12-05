<?php

namespace site\frontend\modules\posts\modules\contractubex\widgets;
use site\frontend\modules\posts\modules\contractubex\components\ContractubexHelper;
use site\frontend\modules\posts\models\Content;

/**
 * @author Никита
 * @date 03/12/15
 */

abstract class ChosenPostsWidget extends \CWidget
{
    public $limit = 5;

    public function run()
    {
        $criteria = ContractubexHelper::getChosenPostsCriteria();
        $criteria->order = 'RAND()';
        $criteria->limit = $this->limit;
        $models = Content::model()->findAll($criteria);
        if (count($models) > 0) {
            $this->render('view', compact('models'));
        }
    }
}