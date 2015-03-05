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
    const DURATION = '+2 day';

    public function toggle($preset, $modelPk, $line, $properties)
    {
        $creative = \Yii::app()->getModule('ads')->creativesFactory->create($preset, $modelPk, $properties);
        $lineId = \Yii::app()->getModule('ads')->lines[$line]['lineId'];
        $ad = Ad::model()->preset($preset)->entity($creative->model)->line($lineId)->find();
        if ($ad === null) {
            return $this->add($preset, $modelPk, $line, $properties);
        } else {
            return ($ad->active == 1) ? $this->remove($ad) : $this->reactivate($ad);
        }
    }

    public function update(Ad $ad)
    {
        $creative = \Yii::app()->getModule('ads')->creativesFactory->create($ad->preset, $ad->entityId, \CJSON::decode($ad->properties));
        \Yii::app()->getModule('ads')->dfp->updateCreative(array(
            'destinationUrl' => $creative->getUrl(),
            'name' => $creative->getName(),
            'htmlSnippet' => $creative->getHtml(),
        ), $ad->creativeId);
    }

    public function add($preset, $modelPk, $line, $properties)
    {
        $localCreative = \Yii::app()->getModule('ads')->creativesFactory->create($preset, $modelPk, $properties);
        $lineConfig = \Yii::app()->getModule('ads')->lines[$line];
        $creative = \Yii::app()->getModule('ads')->dfp->addCreative(array(
            'destinationUrl' => $localCreative->getUrl(),
            'name' => $localCreative->getName(),
            'htmlSnippet' => $localCreative->getHtml(),
        ), $lineConfig['size']);


        $lica = \Yii::app()->getModule('ads')->dfp->addLica($lineConfig['lineId'], $creative->id, array(
            'endDateTime' => $this->getEndDateTime(),
        ));



        $ad = new Ad();
        $ad->entity = get_class($localCreative->model);
        $ad->entityId = $localCreative->model->id;
        $ad->preset = $preset;
        $ad->properties = \CJSON::encode($properties);
        $ad->lineId = $lineConfig['lineId'];
        $ad->creativeId = $creative->id;
        return $ad->save();
    }

    protected function reactivate(Ad $ad)
    {
        \Yii::app()->getModule('ads')->dfp->activateLica($ad->lineId, $ad->creativeId);
        \Yii::app()->getModule('ads')->dfp->updateLica($ad->lineId, $ad->creativeId, array(
            'endDateTime' => $this->getEndDateTime(),
        ));
        $ad->active = 1;
        return $ad->save(true, array('active'));
    }

    protected function remove(Ad $ad)
    {
        \Yii::app()->getModule('ads')->dfp->deactivateLica($ad->lineId, $ad->creativeId);
        $ad->active = 0;
        return $ad->save(true, array('active'));
    }

    private function getEndDateTime()
    {
        return new \DateTime(self::DURATION);
    }
}