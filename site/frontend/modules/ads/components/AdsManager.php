<?php
/**
 * @author Никита
 * @date 04/02/15
 */

namespace site\frontend\modules\ads\components;


use site\frontend\modules\ads\components\creatives\BaseCreative;
use site\frontend\modules\ads\models\Ad;

class AdsManager extends \CApplicationComponent
{
    public function toggle(BaseCreative $creative, $line)
    {
        $model = $creative->model;
        $lineId = \Yii::app()->getModule('ads')->lines[$line]['lineId'];
        $ad = Ad::model()->entity($model)->line($lineId)->find();
        if ($ad === null) {
            return $this->add($model, $creative, $line);
        } else {
            return ($ad->active == 1) ? $this->remove($ad) : $this->reactivate($ad);
        }
    }

    public function update(Ad $ad)
    {


    }

    public function add(\CActiveRecord $model, BaseCreative $localCreative, $line)
    {

        $lineConfig = \Yii::app()->getModule('ads')->lines[$line];
        $creative = \Yii::app()->getModule('ads')->dfp->addCreative(array(
            'destinationUrl' => $localCreative->getUrl(),
            'name' => $localCreative->getName(),
            'htmlSnippet' => $localCreative->getHtml(),
        ), $lineConfig['size']);


        $lica = \Yii::app()->getModule('ads')->dfp->addLica($lineConfig['lineId'], $creative->id);



        $ad = new Ad();
        $ad->entity = get_class($model);
        $ad->entityId = $model->id;
        $ad->lineId = $lineConfig['lineId'];
        $ad->creativeId = $creative->id;
        $ad->
        return $ad->save();
    }

    protected function reactivate(Ad $ad)
    {
        \Yii::app()->getModule('ads')->dfp->activateLica($ad->lineId, $ad->creativeId);
        $ad->active = 1;
        return $ad->save(true, array('active'));
    }

    protected function remove(Ad $ad)
    {
        \Yii::app()->getModule('ads')->dfp->deactivateLica($ad->lineId, $ad->creativeId);
        $ad->active = 0;
        return $ad->save(true, array('active'));
    }
}