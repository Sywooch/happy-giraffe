<?php
/**
 * @author Никита
 * @date 04/02/15
 */

namespace site\frontend\modules\ads\components;


use site\frontend\modules\ads\models\Ad;

class AdsManager extends \CApplicationComponent
{
    public function toggle(\CActiveRecord $model, $line, $template)
    {
        $ad = Ad::model()->entity($model)->line(\Yii::app()->getModule('ads')->lines[$line])->find();
        if ($ad === null) {
            return $this->add($model, $line, $template);
        } else {
            return ($ad->active == 1) ? $this->remove($ad) : $this->reactivate($ad);
        }
    }

    public function update(Ad $ad)
    {


    }

    public function add(\CActiveRecord $model, $line, $template)
    {
        $lineConfig = $lineId = \Yii::app()->getModule('ads')->lines[$line];
        $creativeInfo = new CreativeInfoProvider($template, $model);
        $creative = \Yii::app()->getModule('ads')->dfp->addCreative(array(
            'destinationUrl' => $creativeInfo->url,
            'name' => $creativeInfo->name,
            'htmlSnippet' => $creativeInfo->html,
        ), $lineConfig['size']);
        $lineId = $lineConfig['lineId'];

        $lica = \Yii::app()->getModule('ads')->dfp->addLica($lineId, $creative->id);



        $ad = new Ad();
        $ad->entity = get_class($model);
        $ad->entityId = $model->id;
        $ad->lineId = \Yii::app()->getModule('ads')->lines[$line];
        $ad->creativeId = $creative->id;
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