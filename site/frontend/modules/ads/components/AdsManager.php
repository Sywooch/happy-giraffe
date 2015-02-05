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
        $ad = Ad::model()->entity($model)->line($line)->template($template);
        if ($ad === null) {
            return $this->add($model, $line, $template);
        } else {
            return $this->remove($ad);
        }
    }

    public function update(Ad $ad)
    {


    }

    protected function add(\CActiveRecord $model, $line, $template)
    {
        $creativeInfo = new CreativeInfoProvider($template, $model);
        $creative = \Yii::app()->getModule('ads')->dfp->addCreative($creativeInfo);



        $ad = new Ad();
        $ad->entity = get_class($model);
        $ad->entityId = $model->id;
        $ad->lineId = \Yii::app()->getModule('ads')->lines[$line];
        $ad->creativeId = $creative->id;
        return $ad->save();
    }

    protected function remove(Ad $ad)
    {

    }
}