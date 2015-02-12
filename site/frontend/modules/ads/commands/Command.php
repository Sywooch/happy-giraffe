<?php
namespace site\frontend\modules\ads\commands;
/**
 * @author Никита
 * @date 11/02/15
 */

\Yii::import('site.common.vendor.Google.src.*');
require_once 'Google/Api/Ads/Dfp/Util/DateTimeUtils.php';

class Command extends \CConsoleCommand
{
    public function actionIndex()
    {
        $dp = new \CActiveDataProvider('\site\frontend\modules\ads\models\Ad', array(
            'criteria' => array(
                'order' => 't.id DESC',
                'condition' => 't.active = 1',
            ),
        ));
        $iterator = new \CDataProviderIterator($dp, 100);
        /** @var \site\frontend\modules\ads\models\Ad $ad */
        foreach ($iterator as $ad) {
            $originEntity = $ad->getOriginEntity();
            if ($originEntity->asa('HTimestampBehavior') === null) {
                continue;
            }
            $creative = \Yii::app()->getModule('ads')->dfp->getCreative($ad->creativeId);
            $creativeLastModified = \DateTimeUtils::FromDfpDateTime($creative->lastModifiedDateTime)->getTimestamp();
            $updateAttribute = $originEntity->HTimestampBehavior->updateAttribute;
            $originEntityLastModified = $originEntity->$updateAttribute;
            if ($originEntityLastModified > $creativeLastModified) {
                \Yii::app()->getModule('ads')->manager->update($ad);
            }
        }
    }
}