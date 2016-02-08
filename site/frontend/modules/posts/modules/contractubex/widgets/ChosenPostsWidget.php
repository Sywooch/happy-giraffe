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
        $models = Content::model()->findAll($this->getCriteria());
        if (count($models) > 0) {
            $this->render('view', compact('models'));
        }
    }

    protected function getCriteria()
    {
        $criteria = ContractubexHelper::getChosenPostsCriteria();
        $criteria->order = 'RAND()';
        $criteria->limit = $this->limit;
        return $criteria;
    }
}