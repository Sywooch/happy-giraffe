<?php
/**
 * @author Никита
 * @date 03/12/15
 */

namespace site\frontend\modules\posts\modules\contractubex\widgets\activityWidget;

use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\modules\contractubex\components\ContractubexHelper;

class ActivityWidget extends \CWidget
{
    public function run()
    {
        $dp = $this->getDataProvider();
        $dp->getData();
        $this->render('view', compact('dp'));
    }

    protected function getDataProvider()
    {
        $model = clone Content::model();
        $model->orderDesc();
        $criteria = ContractubexHelper::getChosenPostsCriteria();
        $criteria->mergeWith($model->getDbCriteria());

        return new \CActiveDataProvider('site\frontend\modules\posts\models\Content', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 1,
                'pageVar' => 'page',
            ),
        ));
    }
}